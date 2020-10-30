$(function () {

$('#table-data').DataTable();
 $("[data-mask]").inputmask();

 var checker = document.getElementById('checkme');
 var sendbtn = document.getElementById('sendNewSms');
 // when unchecked or checked, run the function
 checker.onchange = function(){
if(this.checked){
    sendbtn.disabled = false;
} else {
    sendbtn.disabled = true;
}

}

});//end





// $('.btnNext').click(function(){
//   $('.form-hr-sidebar > .active').next('li').find('a').trigger('click');
// });

//   $('.btnPrevious').click(function(){
//   $('.form-hr-sidebar > .active').prev('li').find('a').trigger('click');
// });