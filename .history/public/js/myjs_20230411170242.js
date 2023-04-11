(function($){
    $.fn.TableKuy = function(data = null){
        this.wrapInner("<div class='tablekuy-cont'></div>")
        this.parent().append("<button class='btn btn-primary'></button>")
    }
})(jQuery);