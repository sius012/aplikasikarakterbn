const { forEach } = require("lodash");

(function($){
    $.fn.TableKuy = function(data = null){
        this.wrapInner("<div class='tablekuy-main-cont'></div>")
        var parent = this.parent;
        if(data!=null){

            if(data.buttons!=undefined){
                parent.append("<div class='tablekuy-btn-cont'></div>")
                var btn = data.buttons.map(function(){
                    alert('tes');
                })
            }
           
        }
       
    }
})(jQuery);