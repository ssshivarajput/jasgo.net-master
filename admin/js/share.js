jQuery(document).ready(function() {
    

  setTimeout(function(){
      
      

        console.log('asdsad');
        
    jQuery('.st-btn').on('click',function() {


      if(jQuery(this).attr('data-network') == 'email') {

            
             setTimeout(function(){
                 

            console.log('ssss');                 
        jQuery('.st-send').on('click',function() {

    
          var email = jQuery('.st-recipient').val();
          var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            console.log(email);
            
          if(email.match(mailformat)){
              
              jQuery.post( "/share.php", { email: email,url:  window.location.href} );
          }
        });
        
                 
             },1000)
        

      }


    });

  }, 1000);
});
