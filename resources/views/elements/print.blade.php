@push('css')
<style>
        #buttontPlace{
            margin: 20px;
            padding: 10px;
        }
        #tablehight{
            min-height: 500px;
        }
        #cardHeight{
             height: 1200px
        }
        #footer{
            margin-top: 150px;
            text-align: center;
        }
        #table_context{
            text-align: left;
            vertical-align: middle;
        }

        #signature {
            margin-top: 70px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 0px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
            margin-bottom: 30px;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
</style>
@endpush
@push('js')
<script src='{{ asset('js') }}/print.js'></script>
<script>
$('.print-window').on('click', function() {
    $("#invoice").print({
        addGlobalStyles : true,
        stylesheet : "{{ asset('css') }}/print.css",
        // rejectWindow : true,
        noPrintSelector : "#printSection,#footer",
        // iframe : false,
        append : null,
        prepend : "#footer"
    });
});
</script>
@endpush