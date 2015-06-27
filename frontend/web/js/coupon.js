/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Function checks for filters on click and creates an ajax call
 */
function requestdata(){
    var deal = $("#deal").is(":checked"); //check for coupons checkbox
   
   var coupon = $("#coupon").is(":checked"); //check for deals checkbox
   var xmlhttp;
  
  var brands = $('input[name="Brands"]:checked').val();
  var category = $('input[name="Category"]:checked').val();
  //alert(category);
   //alert(brands);
   if((deal==true && coupon==true) || (deal==false && coupon==false)){
       //alert("both");
       createAjax('both',brands,category);
       
   }
       
   else if(deal==true && coupon==false)
   {
       //alert("deal");
       createAjax('deal',brands,category);
   }
       
   else if(deal==false && coupon==true)
   {
       //alert("coupon");
       createAjax('coupon',brands,category);
   }
       
}        
function toggle(source) {
  checkboxes = document.getElementsByName('deal');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
  
  requestdata();
}

function toggleBrand(source) {
  checkboxes = document.getElementsByName('Brands');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
function toggleCategory(source) {
  checkboxes = document.getElementsByName('Category');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

/*
 * function creates ajax call and returns data.
 */
function createAjax(param1,param2,param3){
    var xmlhttp;
    if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("ajax-data").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","index.php?r=coupon/coupondisplay&param1="+param1+"&param2="+param2+"&param3="+param3,true);
xmlhttp.send();
}


/*
 * function called on clicking download button.
 */
function Download()
{
    
    var deal = $("#deal").is(":checked"); //check for coupons checkbox
   
   var coupon = $("#coupon").is(":checked"); //check for deals checkbox
  
  var brands = $('input[name="Brands"]:checked').val();
  var category = $('input[name="Category"]:checked').val();
  var param1;

   if((deal==true && coupon==true) || (deal==false && coupon==false)){
       //alert("both");
       param1='both';
       
   }
       
   else if(deal==true && coupon==false)
   {
       //alert("deal");
       param1='deal';
   }
       
   else if(deal==false && coupon==true)
   {
       //alert("coupon");
       param1='coupon';
   }
   window.open("index.php?r=coupon/download&param1="+param1+"&param2="+brands+"&param3="+category, '_blank');
          
}