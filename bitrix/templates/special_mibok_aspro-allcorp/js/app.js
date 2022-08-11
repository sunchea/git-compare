$(function(){
    $('#main_content p, #main_content li').attr('tabindex', '0');
	$('#main_content .bx-components-menu li').attr('tabindex', '-1');
	$('#main_content .bx-components-menu li:first').attr('tabindex', '0');
    $('img').attr('tabindex', '0');
    $('#main_content h2, #main_content blockquote, #main_content td, #main_content th').attr('tabindex', '0');
    $('#main_content h3').attr('tabindex', '0');
	$('#main_content h1').attr('tabindex', '0');
    $('#complementary_content h2').attr('tabindex', '0');
    $('#complementary_content h3').attr('tabindex', '0');
    $('#main_content table').addClass('table');
    var $img = $('img');
    for(i=0;i<$img.length;i++){
        if(!$img.eq(i).attr('alt')){
            $img.eq(i).attr('alt', 'Изображение №'+(i+1));
        }
    }    
    var $a = $('a');
    for(i=0;i<$a.length;i++){
        if(!$a.eq(i).attr('title')){
            $a.eq(i).attr('title', $a.eq(i).text());
        }
    }        
    if($('.alert-danger').is('div')){
		$.scrollTo($('.alert-danger'), 300, function(){
			$('.alert-danger').focus();
		});
	}
	if($('.alert-success').is('div')){
		$.scrollTo($('.alert-success'), 300, function(){
			$('.alert-success').focus();
		});
	}       
});

$(document)
        .on('click', '.go-top', function(){
            $.scrollTo('.panel-access', '100', function(){
                $('.panel-access button:first').focus();
            });               
        })        
        .on('submit', '#panel_auth_form .btn-resume', function () {
            $('#panel_auth_form').trigger('submit');
        })
        .on('submit', '#panel_auth_form', function () {
            $(this).ajaxSubmit({
                cache: false,
                url: $(this).attr('action'),
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (data) {
                    $('.help-block').attr('tabindex', '-1');
                    if(data.status == 'success'){
                        $('.panel-auth').removeClass('error');
                        $('.panel-auth').addClass('success');
                        $('.help-block-success').text(data.message).attr('tabindex', '0');
                        //$('#panel_auth_form').css('display', 'none');
                    }
                    if(data.status == 'error'){
                        $('.panel-auth').removeClass('success');
                        $('.panel-auth').addClass('error');
                        $('.help-block-error').text(data.message).attr('tabindex', '0');
                    }
                }
            });
            return false;
        })
		.on('click', '.btn-help-form:not(.active)', function(){
            $(this).parent().find('.alert-info').slideDown({
					duration: 'fast',
					complete: function(){     
						$(this).trigger('focus').attr('tabindex', '0');
						$(this).parent().find('.btn-help-form:not(.active)').addClass('active');
					},
					start: function(){

					}
			});               
        })
		.on('click', '.btn-help-form.active', function(){
            $(this).parent().find('.alert-info').slideUp({
					duration: 'fast',
					complete: function(){  
						$(this).attr('tabindex', '-1');
						$(this).parent().find('.btn-help-form.active').removeClass('active').trigger('focus');
					},
					start: function(){

					}
			});               
        });             