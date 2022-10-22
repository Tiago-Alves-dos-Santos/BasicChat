$(function(){
    let doc = document.documentElement;

    function heightSidebar(){
        $("div.sidebar").css('height', doc.scrollHeight+'px');
    }

    $(document).scroll(function(e) {
        heightSidebar();
    });
        
});