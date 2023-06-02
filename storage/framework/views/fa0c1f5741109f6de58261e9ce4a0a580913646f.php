<!-- ================== BEGIN core-js ================== -->
<script src="<?php echo e(asset('/js/vendor.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/app.min.js')); ?>"></script>
<!-- ================== END core-js ================== -->
<script>
var conn = new WebSocket('ws://localhost:8080');    
conn.onopen = function(e) {
    console.log("Connection established!");
};
function countNotif(){
    let notif = $('.notif-icon');
    $.get("<?php echo e(route('notification.count')); ?>", function(response){
        if (response > 0) {        
            if (notif.find('span.badge').length > 0) {
                notif.find('span.badge').html(response);
            } else {
                $('<span class="badge">'+response+'</span>').insertAfter(notif.find('i'));
            }
        }
    })
}
function getNotif(){
    let notif = $('.live-notif');
    let anote = '';
    notif.find('.dropdown-item').remove();
    $.get("<?php echo e(route('notification.get')); ?>", function(response){
        $.each(response.data, function(i, val){
            anote += '<a href="javascript:;" class="dropdown-item media '+(val.has_read?' bg-default':'')+'">'+
                    '<div class="media-left">'+
                        '<i class="fa fa-bell fa-2x"></i>'+
                    '</div>'+
                    '<div class="media-body">'+
                        '<h6 class="media-heading">'+val.txtnotification+'</h6>'+
                    '</div>'+
                '</a>';
        })
        notif.append(anote);
    }).then(() => {
        $.get("<?php echo e(route('notification.read')); ?>", function(response){
            $('.notif-icon').find('span.badge').remove();
        })
    })
}
function onReadNotif(){
    getNotif();
}
conn.onmessage = function(e) {
    let data = e.data.split(',');
    if (data[1] == 'department') {
        refresh();
    }
};
countNotif();
</script>
<?php echo $__env->yieldPushContent('scripts'); ?><?php /**PATH C:\laragon\www\standardization\resources\views/includes/page-js.blade.php ENDPATH**/ ?>