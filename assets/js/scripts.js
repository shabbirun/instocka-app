(function($){
    $(document).ready(function(){		//when DOM is ready
        burman.init();
    });
    /*
	window.addEventListener("load", function() { pandora.initImageResize(); }, false); 
	$(window).resize(function() {
		pandora.initImageResize();
		pandora.resizeHomepageSlider();
		pandora.adjustCollectionItemHeight();
		pandora.adjustFooterPadding();
		pandora.adjustSliderNavPos();
	});	*/
})(jQuery);

    
    var burman = {
        login: function(){
            $('a#submit').click(function(e){
                e.preventDefault();
                $('#signup').submit();
            });
            
        },
        logout: function(){
           $('#user-logout').click(function(){
              burman.logout_form();
              $('#form-logout').submit();
           })  
        },
        logout_form: function(){
            var f = '<div style="display:none;">';
            f += '<form action="'+base_url+'" method="post" id="form-logout">';
            f += '<input type="hidden" name="page" value="logout" />';
            f += '</form>';
            f +='</div>';
            $('body').append(f);
        },
        admin_btn: function(){
            
        },
        login_enter:function(){
            $('input[type=password]').keydown(function(event){
                //console.log(event.which);
                if(event.which == 13){
                    $('a#submit').trigger('click');
                }
            });
            /*$('input[name=user]').keydown(function(event){
                console.log(event.which);
                if(event.which == 13){
                    $('input[type=password]').focus();
                }
            });*/
        },
        init: function(){
            this.login();
            this.logout();
            this.login_enter();
        }
    }    

