<?php
use yii\widgets\LinkPager;

?>
        <?php yii\widgets\Pjax::begin() ?>    

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
                    
                    
                   
                      <?php yii\widgets\Pjax::end() ?>                     