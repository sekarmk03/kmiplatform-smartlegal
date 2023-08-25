<!-- ================== BEGIN core-js ================== -->
<script src="{{ asset('/js/vendor.min.js') }}"></script>
<script src="{{ asset('/js/app.min.js') }}"></script>
<!-- ================== END core-js ================== -->
<script>
var conn = new WebSocket('ws://localhost:8080');    
conn.onopen = function(e) {
    console.log(e);
};
function countNotif(){
    let notif = $('.notif-icon');
    $.get("{{ route('notification.count') }}", function(response){
        if (response.count > 0) {        
            if (notif.find('span.badge').length > 0) {
                notif.find('span.badge').html(response.count);
            } else {
                $('<span class="badge">'+response.count+'</span>').insertAfter(notif.find('i'));
            }
        }
    })
}
function getNotif(){
    let notif = $('.live-notif');
    let anote = '';
    notif.find('.dropdown-item').remove();
    $.get("{{ route('notification.get') }}", function(response){
        $.each(response.data, function(i, val){
            anote += '<a href="javascript:;" class="dropdown-item media '+(val.read_at != ''?' bg-default':'')+'">'+
                    '<div class="media-body">'+
                        '<h6 class="media-heading">'+val.data.title+'</h6>'+
                        '<p>'+val.data.message+'</p>'+
                    '</div>'+
                '</a>';
        })
        notif.append(anote);
    }).then(() => {
        $.get("{{ route('notification.read') }}", function(response){
            $('.notif-icon').find('span.badge').remove();
        })
    })
}
function onReadNotif(){
    getNotif();
}
function openFullscreen() {
    let elem = document.documentElement;
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (elem.requestFullScreen) {
            elem.requestFullScreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}
conn.onmessage = function(e) {
    countNotif();
};
countNotif();
</script>
@stack('scripts')