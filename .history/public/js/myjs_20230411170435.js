(function($){
    $.fn.TableKuy = function(data = null){
        this.wrapInner("<div class='tablekuy-cont'></div>")
        var parent = this.parent;
        if(data!=null){

            if(data.buttons!=undefined){
                parent.append("<div class='tabl></div>")
            }
           
        }
       
    }
})(jQuery);