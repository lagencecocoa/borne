<?php

class Wishlisted
{

    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    function actionWishlist($mail, $serial, $name, $firstname){
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $rq = "INSERT INTO borne_wishlist (email, products, creation_date, name, firstname) VALUES (?, ?, ?, ?, ?)";
            $query_rq = $this->db->prepare($rq);
            $query_rq->execute(array($mail,$serial,date("Y-m-d H:i:s"), $name, $firstname));

            $sujet = 'Votre Whislist';
            $message ='<html>
            <head>
            <title>Votre Whislist du '.date("d-m-Y").'</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta charset=UTF-8">
            </head>
            <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
                <h4>Récapitulatif de votre wishlist du '.date("d-m-Y").'</h4><br>
                <table class="table">
                    <thead>
                      <tr>
                        <td style="font-weight:bold">Identifiant du produit</td>
                        <td style="font-weight:bold">Nom du produit</td>
                        <td style="font-weight:bold">Catégorie</td>
                        <td style="font-weight:bold">Référence</td>
                      </tr>
                    </thead>
                    <tbody>';
                     foreach(unserialize($serial) as $p){

                      $message .= '<tr>
                                    <td>'.$p->art_seq.'</td>
                                    <td>'.$p->art_lib.'</td>
                                    <td>'.$p->art_famille.'</td>
                                    <td>'.$p->condref_autreref.'</td>
                                  </tr>';

                     }

            $message .='</tbody></table></body></html>';

            $headers = 'From:<admin@lagencecocoa.com>'.PHP_EOL;
            $headers .= 'Reply-To: admin@prestamed.com'.PHP_EOL;
            $headers .= "MIME-Version: 1.0".PHP_EOL;
            $headers .= "Content-Type: text/html; charset=ISO-8859-1".PHP_EOL;

            // mail function not working on localhost
            //
            // if (mail($mail,$sujet,$message,$headers)){
            //     echo '<script type="text/javascript">window.location.href = "/wishlist/index";</script>';
            // }

              echo '<script type="text/javascript">window.location.href = "/wishlist/index";</script>';
              

        }else{
            echo "Cette adresse email est invalide.";
        }


    }

    function getAllWishlist(){
        $rqArt = "SELECT * FROM borne_wishlist";
        $query_rqArt = $this->db->prepare($rqArt);
        $query_rqArt->execute();

        return $query_rqArt->fetchAll();
    }

    function delWishlist($id) {
        $wishlist = "DELETE FROM borne_wishlist WHERE id = ?";
        $query_wishlist = $this->db->prepare($wishlist);
        $query_wishlist->execute($id);
    }

    function getProductsWished($wishlist){

        $pwish = array();

        foreach($wishlist as $w){
            $rqArt = "SELECT *FROM orthop_article LEFT OUTER JOIN orthop_fournisseur ON frs_chrono = art_fabricant LEFT OUTER JOIN orthop_tva ON tva_code = art_tva_vte WHERE art_seq = ? LIMIT 1";
            $query_rqArt = $this->db->prepare($rqArt);
            $query_rqArt->execute(array($w));

            $article = (object) $query_rqArt->fetch(PDO::FETCH_ASSOC);

            if ($article){

                // LPP article
                $rqLpp = "SELECT * FROM orthop_cnam_lpp_fiche LEFT OUTER JOIN orthop_cnam_lpp_histo ON lpph_codelpp = ? WHERE lppf_codelpp = ? AND (lpph_datdebval < CURRENT_DATE OR lpph_datdebval = '0000-00-00 00:00:00' OR lpph_datdebval IS NULL) AND (lpph_datfinval > CURRENT_DATE OR lpph_datfinval = '0000-00-00 00:00:00' OR lpph_datfinval IS NULL) LIMIT 1";
                $query_rqLpp = $this->db->prepare($rqLpp);
                $query_rqLpp->execute(array($article->art_lppvte,$article->art_lppvte));

                if ($rLpp = $query_rqLpp->fetch(PDO::FETCH_ASSOC))
                    foreach ($rLpp as $k => $v)
                        $article->$k = $v;


                $rqCond = "SELECT * FROM orthop_conditionnement LEFT OUTER JOIN orthop_cnam_lpp_fiche ON lppf_codelpp = cond_lppvte LEFT OUTER JOIN orthop_cnam_lpp_histo ON lpph_codelpp = cond_lppvte WHERE cond_article = ? AND (lpph_datdebval < CURRENT_DATE OR lpph_datdebval = '0000-00-00 00:00:00' OR lpph_datdebval IS NULL) AND (lpph_datfinval > CURRENT_DATE OR lpph_datfinval = '0000-00-00 00:00:00' OR lpph_datfinval IS NULL)";
                $query_rqCond = $this->db->prepare($rqCond);
                $query_rqCond->execute(array($w));


                $article->_conditionnements = array();
                while ($rqCond_row = $query_rqCond->fetch(PDO::FETCH_ASSOC))
                    $article->conditionnements[] = $rqCond_row;

                // Arbre des conditionnements commandables
                if (!function_exists('getParentCond')) {
                    function getParentCond($pCondSeq, Array $pConds)
                    {
                        $parent = null;
                        foreach ($pConds as $c)
                            if ($c['cond_pere'] == $pCondSeq)
                            {
                                $parent = $c;
                                break;
                            }
                        return $parent;
                    }
                }

                $new_cond = array();
                foreach ($article->_conditionnements as $c)
                {
                    // Si cond_unite != 'uni'
                    if ($c->cond_unite != 'uni')
                        $new_cond[] = $c;
                    else
                    {
                        $parent_cond = getParentCond($c->cond_seq, $article->_conditionnements);
                        // Si aucun cond n'a cond_pere = cond_seq de cond courant
                        if (!$parent_cond)
                            $new_cond[] = $c;
                        else
                            // Si parent_cond_unite != 'uni'
                            if ($parent_cond->cond_unite != 'uni')
                                $new_cond[] = $c;
                    }
                }

                $article->conditionnements = $new_cond;

                foreach ($article->_conditionnements as & $c)
                {
                    // Prix conditionnement
                    $rqPrix = "SELECT px_qte, px_uht FROM orthop_prix WHERE px_conditionnement = ? AND px_tarif = '1' AND px_location = 0 ORDER BY px_qte";
                    $query_rqPrix = $this->db->prepare($rqPrix);
                    $query_rqPrix->execute(array($c->cond_seq));


                    $c->prix = array();
                    while ($rqPrix_row = $query_rqPrix->fetch(PDO::FETCH_ASSOC))
                        $c->_prix[] = $rqPrix_row;

                    if ( ! $c->_prix)
                    {
                        $c->prix = self::_GetParentPrice($c->cond_seq);
                    }

                }

                // Composants article (+ LPP)

                $rqComp = "SELECT orthop_art_composant.*, orthop_cnam_lpp_fiche.*, orthop_cnam_lpp_histo.* FROM orthop_art_composant INNER JOIN orthop_conditionnement ON cond_seq = acomp_conditionnement LEFT OUTER JOIN orthop_cnam_lpp_fiche ON lppf_codelpp = cond_lppvte LEFT OUTER JOIN orthop_cnam_lpp_histo ON lpph_codelpp = cond_lppvte WHERE acomp_article = ? AND (lpph_datdebval < current_date OR lpph_datdebval = '0000-00-00 00:00:00' OR lpph_datdebval IS NULL) AND (lpph_datfinval > current_date OR lpph_datfinval = '0000-00-00 00:00:00'  OR lpph_datfinval IS NULL) ORDER BY acomp_ordre, acomp_seq";
                $query_rqComp = $this->db->prepare($rqComp);
                $query_rqComp->execute(array($w));


                $article->_composants = (object) array();
                while ($rqComp_row = $query_rqComp->fetch(PDO::FETCH_ASSOC))
                    $article->_composants[] = $rqComp_row;
            }

            array_push($pwish,$article);
        }

        return $pwish;
	}


}
