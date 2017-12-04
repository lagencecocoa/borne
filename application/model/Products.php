<?php

class Products
{

    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    function getAllCategories(){
        $res_rayons = "SELECT * FROM `orthop_art_rayon` WHERE `actif`='1' ORDER BY `ordre_affichage` ASC, `ray_code` ASC";
        $query_res_rayons = $this->db->prepare($res_rayons);
        $query_res_rayons->execute();

		$res_familles = "SELECT * FROM `orthop_art_famille` WHERE `actif`='1' ORDER BY `ordre_affichage` ASC, `fam_code` ASC";
		$query_res_familles = $this->db->prepare($res_familles);
        $query_res_familles->execute();

		$allCategories = array();

		while ($row_rayon = $query_res_rayons->fetch(PDO::FETCH_ASSOC))
		{
             $hex = str_replace("#", "", '#'.$row_rayon['color']);

               if(strlen($hex) == 3) {
                  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
               } else {
                  $r = hexdec(substr($hex,0,2));
                  $g = hexdec(substr($hex,2,2));
                  $b = hexdec(substr($hex,4,2));
               }
               $rgb = array($r, $g, $b, '0.8');
               $rgb = implode(",", $rgb);
               $rgb_sub = array($r, $g, $b, '0.3');
               $rgb_sub = implode(",", $rgb_sub);

			$allCategories[$row_rayon['ray_code']] = (object) array(
				'id' => $row_rayon['ray_code'],
				'handle' => $row_rayon['handle'],
				'image' => $row_rayon['image'],
				'backgroundcolor' => $rgb,
                'backgroundcolor_sub' => $rgb_sub,
				'label' => $row_rayon['ray_web_lib'],
				'items' => array()
			);
		}

		while ($row_famille = $query_res_familles->fetch(PDO::FETCH_ASSOC))
		{
			if (isset($allCategories[$row_famille['fam_rayon']]))
			{
				$allCategories[$row_famille['fam_rayon']]->items[] = (object) array(
					'id' => $row_famille['fam_code'],
					'handle' => $row_famille['handle'],
					'label' => $row_famille['fam_lib']
				);
			}
		}
		$categories = (object) $allCategories;
		return $categories;
    }

    public function getCurrentCategory($id){
        $rq = "SELECT * FROM `orthop_art_rayon` WHERE `actif`='1' AND ray_code = ?";
        $query = $this->db->prepare($rq);
        $query->execute(array($id));

        return $query->fetch();

    }

    public function getSubCatCurrentCategory($id){
		$rq = "SELECT * FROM `orthop_art_famille` WHERE `actif`='1' AND `fam_rayon` = ? ORDER BY `ordre_affichage` ASC, `fam_code` ASC";
		$query = $this->db->prepare($rq);
        $query->execute(array($id));
        return $query->fetchAll();
    }


    public function productsCurrentParentCategory(Array $categories){
        $res = array();
            foreach ($categories as $c){
                $res = array_merge($res,self::ProductGetListByFamilleCode($c->fam_code));
            }
        return $res;
	}


    public function ProductGetListByFamilleCode($pCode)
	{
        $rq = "SELECT * FROM `orthop_article` WHERE `art_famille` = ? ORDER BY `art_lib` DESC";
		$query = $this->db->prepare($rq);
        $query->execute(array($pCode));

		$res = array();
		while ($rq_row = $query->fetch(PDO::FETCH_ASSOC))
			$res[] = (object) $rq_row;
		return (object) $res;
	}

    public function getProduct($artseq)
	{
        $rq = "SELECT * FROM `orthop_article` WHERE `art_seq` = ?";
		$query = $this->db->prepare($rq);
        $query->execute(array($artseq));

		return $query->fetch();
	}

    
    
    public function ProductGetBySeq($pArtSeq)
	{
        
        $rqArt = "SELECT *FROM orthop_article LEFT OUTER JOIN orthop_fournisseur ON frs_chrono = art_fabricant LEFT OUTER JOIN orthop_tva ON tva_code = art_tva_vte WHERE art_seq = ? LIMIT 1";
		$query_rqArt = $this->db->prepare($rqArt);
        $query_rqArt->execute(array($pArtSeq));
		
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
            $query_rqCond->execute(array($pArtSeq));

          
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
            $query_rqComp->execute(array($pArtSeq));
		
			
			$article->_composants = (object) array();
			while ($rqComp_row = $query_rqComp->fetch(PDO::FETCH_ASSOC))
				$article->_composants[] = $rqComp_row;
		}
		
		return (object) $article;
	}
    
    private static function _GetParentPrice($pCondSeq)
	{
		$r = array();
		
        $rqCond = "SELECT * FROM orthop_conditionnement LEFT OUTER JOIN orthop_cnam_lpp_fiche ON lppf_codelpp = cond_lppvte LEFT OUTER JOIN orthop_cnam_lpp_histo ON lpph_codelpp = cond_lppvte WHERE cond_seq = ? AND (lpph_datdebval < CURRENT_DATE OR lpph_datdebval = '0000-00-00 00:00:00' OR lpph_datdebval IS NULL) AND (lpph_datfinval > CURRENT_DATE OR lpph_datfinval = '0000-00-00 00:00:00' OR lpph_datfinval IS NULL)LIMIT 1";
        $query_rqCond = $this->db->prepare($rqCond);
        $query_rqCond->execute(array($pCondSeq));
        
		if ($cond = $query_rqCond->fetch(PDO::FETCH_ASSOC))
		{
			// Prix
            $rqPrix = "SELECT px_qte, px_uht FROM orthop_prix WHERE px_conditionnement = '%s' AND px_tarif = '1' AND px_location = 0 ORDER BY px_qte";
            $query_rqPrix = $this->db->prepare($rqPrix);
            $query_rqPrix->execute(array($cond->cond_seq));
            
            
			// Prix OK >> STOP
			if ($query_rqPrix->rowCount())
			{
				while ($prix = $query_rqPrix->fetch(PDO::FETCH_ASSOC))
					$r[] = $prix;
				//<<STOP>>
			}
			// Prix KO
			else
			{
				// cond_pere != NULL
				if ($cond->cond_pere && strtolower($cond->cond_pere) != 'null')
				{
					$r = self::_GetParentPrice($cond->cond_pere);
				}
			}
			
			return $r;
		}
	}
    
    public static function RenderProductListSimilar(Array $pProducts, $currentProductId)
	{	
        
     $cnt = count($pProducts);
		
	 foreach ($pProducts as $key=>$pProduct) {
         $produit = self::ProductGetBySeq($pProduct->art_seq);
         $renderPrice[] = self::RenderPrice($produit);
     }
        
     foreach ($pProducts as $key=>$pProduct){
         if ($pProduct['art_seq'] != $currentProductId) {
             $class = 'product-list-li-'.(($key>4)?($key%5):$key);
             self::RenderProductsimilar($pProduct,$class);
         }
     }

	}
  



    public function addThumbnail($subCat)
    {
      for ($i=0; $i<count($subCat); $i++) {
        $products = self::ProductGetListByFamilleCode($subCat[$i]->fam_code);
        $subCat[$i]->image = reset($products)->art_seq;
      }
      return $subCat;
    }


}

