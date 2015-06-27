<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Coupon;
use frontend\models\Website;
use frontend\models\CouponCategories;
use yii\web\Controller;
use yii\data\Pagination;
use PHPExcel;

/**
 * CouponController
 */
class CouponController extends Controller
{
    
    public function actionIndex()
    {
        
        $query = Coupon::find();
        
        $brands = $this->getAllBrand();
        $category = $this->getAllCategories();
        
        
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);
        
        
            $couponsall = $query
                       
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();

        return $this->render('index', [
            'couponsall' => $couponsall,
            'brands' => $brands,
            'category'=>$category,
            'pagination' => $pagination,
        ]);
    }
   
    /**
     * Coupondisplay action renders partially the filtered coupons on coupondisplay view which is
     * then returned as response to the ajax call and shown in div on index page.
     * @param1 Coupon Type (deal,coupon,both)
     * @param2 WebsiteID (brand) (allbrands or WebsiteID)
     * @param3 CategoryId (category) (allcategory or CouponID)
     * @return filtered coupons to coupondisplay view
     *
     */
    public function actionCoupondisplay($param1,$param2,$param3)
    {
        //$this->layout='';
        
        if(isset($_GET['param1']))
        $pname = $_GET['param1'];
        else
            $pname  = 'both';
        if(isset($_GET['param2'])){
          $bname = $_GET['param2'];
          
        }
        
        else
            $bname  = 'allbrands';
        
        if(isset($_GET['param3']))
        $cname = $_GET['param3'];
        else
            $cname  = 'allcategory';
              

        $couponsall= $this->getData($pname,$bname,$cname);
        
        //$pagination->totalCount = 4;
        
            return $this->renderPartial('coupondisplay', [
            'couponsall' => $couponsall,
           
        ]);
    }
    
    private function getAllBrand() {
        
        $brands =  Website::find()
                    ->orderBy('WebsiteName')
                    ->all();
        
            return $brands;
        
    }
    
    private function getAllCategories() {
        
        $category = CouponCategories::find()
                    ->orderBy('Name')
                    ->all();
        
            return $category;
        
    }
    
    /**
     *  action to Download filtered coupons
     * @param1 Coupon Type (deal,coupon,both)
     * @param2 WebsiteID (brand) (allbrands or WebsiteID)
     * @param3 CategoryId (category) (allcategory or CouponID)
     * @return filtered coupons to coupondisplay view
     *
     */
    
    public function actionDownload($param1='both',$param2='allbrands',$param3='allcategory') {
       
        $objPHPExcel = new \PHPExcel();
        
        if(isset($_GET['param1']))
        $pname = $_GET['param1'];
        else
            $pname  = 'both';
        if(isset($_GET['param2'])){
          $bname = $_GET['param2'];
          
        }
        
        else
            $bname  = 'allbrands';
        
        if(isset($_GET['param3']))
        $cname = $_GET['param3'];
        else
            $cname  = 'allcategory';
        
        //list($couponsall,$pagination)=  $this->
        
        
        
        $coupon=$this->getData($pname, $bname, $cname);
        $i = 1;
        foreach ($coupon as $cp) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $cp->CouponID)
            ->setCellValue('B'.$i, $cp->Title)
            ->setCellValue('C'.$i, $cp->Description)
            ->setCellValue('D'.$i, $cp->CouponCode)
            ->setCellValue('E'.$i, $cp->website->WebsiteName);
            $i++;
        }
        
 
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('CouponDetails');
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a clientâ€™s web browser (Excel5)
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        // It will be called file.xls
        header('Content-Disposition: attachment; filename="coupons.xls"');
        //$objWriter->save('php://output');

    }
    
    /**
     *  This function returns the filtered coupons data to the calling actions.
     * @param1 Coupon Type (deal,coupon,both)
     * @param2 WebsiteID (brand) (allbrands or WebsiteID)
     * @param3 CategoryId (category) (allcategory or CouponID)
     * @return filtered coupons to coupondisplay view
     *
     */
    
    private function getData($pname,$bname,$cname){
    
        $query = Coupon::find();
        
        if($pname=='coupon'){
            
            if($bname=='allbrands'){
                
                if($cname=='allcategory')
                {
                    
                    $couponsall = $query
                    ->where('IsDeal=0')        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                    ->limit(100)
                   
                    ->all();
                }
                else
                {
                    $couponsall = $query
                    ->where('IsDeal=0 && CouponCategories.CategoryID='.$cname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                   ->limit(100)
                    ->all();
                }
                
              
              
            }
            else
            {
                if($cname=='allcategory')
                {
                    
                    $couponsall = $query
                    ->where('IsDeal=0 && WebsiteID='.$bname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                   ->limit(100)
                    ->all();
                }
                else
                {
                    $couponsall = $query
                    ->where('IsDeal=0 && CouponCategories.CategoryID='.$cname.' && WebsiteID='.$bname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                   ->limit(100)
                    ->all();
                }
            }
            
            
            
        }
        else if($pname=='deal'){
            
            if($bname=='allbrands'){
                
                if($cname=='allcategory')
                {
                    
                    $couponsall = $query
                    ->where('IsDeal=1')        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                   ->limit(100)
                    ->all();
                }
                else
                {
                    $couponsall = $query
                    ->where('IsDeal=1 && CouponCategories.CategoryID='.$cname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                   ->limit(100)
                    ->all();
                }
                
              
              
            }
            else
            {
                if($cname=='allcategory')
                {
                    
                    $couponsall = $query
                    ->where('IsDeal=1 && WebsiteID='.$bname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                  ->limit(100)
                    ->all();
                }
                else
                {
                    $couponsall = $query
                    ->where('IsDeal=1 && CouponCategories.CategoryID='.$cname.' && WebsiteID='.$bname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                 ->limit(100)
                    ->all();
                }
            }
            
        }
        else
        {
            
            if($bname=='allbrands'){
                
                if($cname=='allcategory')
                {
                    
                    $couponsall = $query
                       
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                ->limit(100)
                    ->all();
                }
                else
                {
                    $couponsall = $query
                    ->where('CouponCategories.CategoryID='.$cname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                   ->limit(100) 
                    ->all();
                }
                
              
              
            }
            else
            {
                if($cname=='allcategory')
                {
                    
                    $couponsall = $query
                    ->where('WebsiteID='.$bname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                    ->limit(100)
                    ->all();
                }
                else
                {
                    $couponsall = $query
                    ->where('CouponCategories.CategoryID='.$cname.' && WebsiteID='.$bname)        
                    ->orderBy('CouponID')
                    ->with('website')
                    ->joinWith('couponCategories')
                    ->limit(100)
                    ->all();
                }
            }
        }
        
        
        
        return $couponsall;
}
}
