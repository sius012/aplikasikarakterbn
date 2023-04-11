

(function($){
    $.fn.TableKuy = function(data = null){
        this.wrapInner("<div class='tablekuy-main-cont'></div>")
        var parent = this.parent();
        alert('tes')
        if(data!=null){
        
            if(data.tombol!=undefined){
                parent.append("<div class='tablekuy-btn-cont'></div>")
              
                var btn = data.tombol.map(function(){
                    alert('tes');
                });
            }
           
        }
       
    }
})(jQuery);