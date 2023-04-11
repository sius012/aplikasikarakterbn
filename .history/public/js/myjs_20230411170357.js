(function($){
    $.fn.TableKuy = function(data = null){
        this.wrapInner("<div class='tablekuy-cont'></div>")
        if(data!=null){

            if(data.buttons!=undefined){

                this.parent().append("<div class='wrap></div>")
            }
           
        }
       
    }
})(jQuery);