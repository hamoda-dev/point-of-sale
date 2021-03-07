<script>
    $(document).ready(function () {
        $(".delete-confirmation").click(function(event){
            event.preventDefault();
            swal({
                icon : "warning",
                title : "هل انت متأكد ؟",
                text : "لا يمكنك استعادة البيانات التي تحذفها",
                buttons: {
                    confirm: "@lang('site.yes')",
                    cancel: "@lang('site.no')",
                }

            })
            .then((value) => {
                switch (value) {

                    case true:
                        $(this).parent().submit();
                        break;

                    case null:
                        return false;
                        break;

                    default:
                        swal("حدث خطاء الرجاء المحاولة مرة اخرى");
                }
            })
        });
    });
</script>
