$(function(){
    $('#generateOrder').submit(function(e){
        if ( !$('.selectGroup').val() )
          {
            e.preventDefault();
            $('#selectGroup').modal('show');  
          }
    })
    
    $('.js-datepicker').datepicker({autoclose: true, todayHighlight: false, format: "dd.mm.yyyy"});
})