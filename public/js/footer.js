$(function(){
    let doc = document.documentElement;
    function heightSidebar(){
        $("div.sidebar").css('height', doc.scrollHeight+'px');
    }

    function showLoadPage(){
        $("#load-page").css('height', doc.scrollHeight+'px');
        $("#load-page").fadeIn();
        
    }

    function showLoadPageSubmit(){
        $('.submit-loadPage').on('submit', function(){
            showLoadPage();
        });
    }
    function showLoadPageClick(){
        $('.click-loadPage').on('click', function(){
            showLoadPage();
        });
    }
    showLoadPageClick();
    showLoadPageSubmit();

    $(document).scroll(function(e) {
        heightSidebar();
    });
        
});