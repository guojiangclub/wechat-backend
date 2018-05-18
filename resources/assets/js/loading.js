function LoadCSS(url) {
    var link = document.createElement('link');
    link.type = 'text/css';
    link.rel = 'stylesheet';
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}

function loadScript(url) {
    var script = document.createElement('script');
    script.type = 'text/jacascript';
    script.src = url;
    $('body').append(script);
}


