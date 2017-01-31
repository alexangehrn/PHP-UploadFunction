$(document).ready(function(){
   $('#ch_carre_dim').css({"display":"none"});
   $('#ch_rectangle_dim').css({"display":"none"});

   $('#myForm input').on('change', function() {
   if($('input[name="ch_rectangle"]:checked', '#myForm').val() == "carre"){
   		$('#ch_carre_dim').css({"display":"block"});
   		$('#ch_rectangle_dim').css({"display":"none"});
   }
});
      $('#myForm input').on('change', function() {
   if($('input[name="ch_rectangle"]:checked', '#myForm').val() == "rectangle"){
   		$('#ch_carre_dim').css({"display":"none"});
   		$('#ch_rectangle_dim').css({"display":"block"});
   }
});
       $('#plus').click(function() {
      $( "#input-bloc" ).append("<input type='file' name='ch_file[]' class='mon_fichier' required/>");
  });
        $('#moins').click(function() {
        	$(".mon_fichier").remove();
  });

   $('#texte_html').css({"display":"none"});

   $('#myForm input').on('change', function() {
   if($('input[name="ch_content"]:checked', '#myForm').val() == "Text"){
      $('#text_brut').css({"display":"block"});
      $('#texte_html').css({"display":"none"});
   }
});
      $('#myForm input').on('change', function() {
   if($('input[name="ch_content"]:checked', '#myForm').val() == "HTML"){
      $('#text_brut').css({"display":"none"});
      $('#texte_html').css({"display":"block"});
   }
});
});