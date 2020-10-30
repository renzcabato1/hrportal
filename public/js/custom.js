$(function () {

$('#table-data').DataTable();

 $("[data-mask]").inputmask();

    $.fn.select2.defaults.set("theme", "bootstrap");
    $("#select2").select2({
         width: null,
          placeholder: "Select birthplace",
    });

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


$('.btnNext').click(function(){
  $('.nav > .active').next('li').find('a').trigger('click');
});

  $('.btnPrevious').click(function(){
  $('.nav > .active').prev('li').find('a').trigger('click');
});