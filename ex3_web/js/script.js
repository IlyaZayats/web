$(document).ready(function (){
    $('#check').change((event)=>{
        if($('#check').is(":checked")){
            $('#submitButton').prop("disabled", false)
        }else{
            $('#submitButton').prop("disabled", true);
        }
    });
});