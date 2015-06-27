
<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

?>
<style>
body {
    background-color: teal;
    color: #333;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 1.42857;
}
p.word {
    width: 40em; 
    word-wrap: break-word;
}
#coupons{
    border-radius: 25px;
    border: 2px solid #8AC007;
    padding: 20px; 
     
}

    </style>
    <script src="js/coupon.js"></script>
<div class="container-fluid" style="margin-top:-10px">
    <!--<div class="row" >
		<div class="col-md-12" style="z-index: 1000;background-color:cornsilk;"  >
                    <div class="page-header" >
				<h1>
					Your Coupons are Here! 
				</h1>
			</div>
		</div>
	</div> -->
    <div class="row">
            <div class="col-md-4" >
			<div class="panel-group" id="panel-158751" style="position:fixed; width:350px">
				<div class="panel panel-default">
					<div class="panel-heading" id="panel1">
						 <a class="panel-title collapsed" x data-toggle="collapse" data-parent="#panel-158751" href="#panel-element-401808">Deal Type</a>
					</div>
					<div id="panel-element-401808" class="panel-collapse collapse">
						<div class="panel-body">
                                                    <form role="form" onsubmit="requestdata();" action="#">
				
				
				
				<div class="checkbox">
					<!-- 
					<label>
                                            <input type="checkbox" onClick="toggle(this)" /> Select All
                                            </label><br> -->
                                    <label>
                                        <input type="checkbox" id="deal" name="deal" value="Deal" onchange="requestdata();"> Deal
                                        </label><br>
                                        <label>
                                                <input type="checkbox" id="coupon" name="deal" value="Coupon" onchange="requestdata();"> Coupon
					</label>
				</div> 
                                                       <!-- <button type="submit" class="btn btn-default" onclick="alert('Hello');">
					Submit
				</button> -->
			</form>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						 <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-158751" href="#panel-element-896831">Brand</a>
					</div>
					<div id="panel-element-896831" class="panel-collapse collapse">
						<div class="panel-body">
							<form role="form">
				
				<div class="checkbox" style="overflow-y: scroll; height:300px;">
					 
					<label>
                                            <input type="radio"  name="Brands" id="allbrands" checked="true" onchange="requestdata();" value="allbrands"/> Select All
                                                </label>
                                    <br>
                                                <?php foreach ($brands as $brand) { ?>
                                <label>
                                    <input type="radio" id="allbrands" value="<?= $brand->WebsiteID; ?>" name ="Brands" onchange="requestdata();">
                                        <?php echo $brand->WebsiteTitle; ?>
                                       </label><br>
                            <?php } ?> 
					
				</div> 
				
			</form>
						</div>
					</div>
				</div>
                            <div class="panel panel-default">
					<div class="panel-heading">
						 <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-158751" href="#panel-element-896833">Categories</a>
					</div>
					<div id="panel-element-896833" class="panel-collapse collapse">
						<div class="panel-body">
							<form role="form">
				
				<div class="checkbox" style="overflow-y: scroll; height:300px;">
					 
                                    <label>
                                        <input type="radio" name="Category" id="category" checked="true" value="allcategory" onchange="requestdata();"/> Select All
                                    </label>      
                                    <br>
                                                <?php foreach ($category as $brand) { ?>
                                <label>
                                    <input type="radio" id="category" value="<?= $brand->CategoryID; ?>" name ="Category" onchange="requestdata();">
                                        <?php echo $brand->Name; ?>
                                       </label><br>
                            <?php } ?> 
					
				</div>
				
			</form>
						</div>
					</div>
				</div>
			</div>
		</div>
        
        <?php yii\widgets\Pjax::begin() ?>
        <div id="ajax-data">
            
        <div class="col-md-8">
					<div class="row">
                                            
                                            <?php foreach ($couponsall as $coupons): ?>
						<div class="col-md-12" style="background: mintcream none repeat scroll 0 0;

-moz-box-shadow:  0px 0px 0px 0px rgb(128,128,128);
-webkit-box-shadow:  0px 0px 0px 0px rgb(128,128,128);
box-shadow:  0px 0px 0px 0px rgb(128,128,128); margin-bottom: 20px  ;  border-radius: 10px;
">
							<div class="row">
								<div class="col-md-8">
                                                                    <h3>
				<?= $coupons->website->WebsiteName;?>
			</h3>
								</div>
                                                            
								<div class="col-md-4">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
                                                                    <blockquote class="pull-right" style="height:200px">
                                                                        <p class="word">
					<?= $coupons->Description;?>
				</p> <small><cite><?= $coupons->Title;?></cite></small>
			</blockquote>
								</div>
							</div>
							<div class="row">
								<div class="col-md-8">
                                                                    <ul class="nav nav-pills">
						<li class="active">
							 <a href="#"> <span class="badge pull-left"><?= $coupons->CountSuccess?></span>Success </a>
						</li>
						<li>
							 <a href="#"> <span class="badge pull-left"> <?= $coupons->CountFail?></span>Fails</a>
						</li>
					</ul>
                                                                    
								</div>
                                                            <div class="col-md-4" align="right;" style="margin-bottom:10px">
                                                                    <button type="button" class="btn btn-lg btn-success btn-block" onClick="window.open('<?= $coupons->website->WebsiteURL?>')" formtarget="_blank">
                                                                        <?php if($coupons->IsDeal == 0)
						echo $coupons->CouponCode;
                                                                else
                                                                    echo "GRAB DEAL";?>
                                                                
					</button>
								</div>
							</div>
						</div>
                                            <?php endforeach; ?>
                    
                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                                       <?php yii\widgets\Pjax::end() ?>     
                                            </div>
            
					</div>
            
				</div>
        
	
        </div>
</div>
    <div class="download">
    <button type="button" class="btn btn-primary" style="position:fixed;
right:0;
bottom:60px;" onclick="Download();">
  <span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download
</button>
    </div>
    