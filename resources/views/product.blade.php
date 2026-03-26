<html>
    <head>
        <link rel="stylesheet" href="http://cdn.datatables.net/2.3.7/css/dataTables.dataTables.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css" />
    </head>
    <body>
        <h1>Products (Data Odoo)</h1>
        <div>
            <table id="odooTable" class="stripe table hover">
                <thead>
                    <tr><th>ID</th><th>Code</th><th>Name</th><th>Price</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <input id="fileInput" type="file" style="display:none;" />
    </body>
    <script src="http://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="http://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
    <script src="http://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
    <script src="http://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>

    <script src="{{ asset('assets/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/jszip/jszip.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#odooTable').DataTable({
                ajax:{"url": "/products"}, // Memanggil route JSON kita
                responsive: true, // Wajib untuk PWA/Mobile
                processing: true,
                pageLength: 10,
                dom:"Bfrtip",
                columns: [
                    { data: 'id' },
                    { data: 'code' },
                    { data: 'name' },
                    { data: 'price' },
                ],
                language: {
                    search: "Cari Produk:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ produk",
                    paginate: {
                        next: "Lanjut",
                        previous: "Kembali"
                    }
                },
                buttons:[
                    {
                        extend: 'excelHtml5',
                        text: 'Unduh Spreadsheet',
                        className: 'btn-export',
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
                        },
                    },
                    {
                        text: '<i class="fa-solid fa-ticket"></i> Unggah Spreadsheet',
                        className:'btn btn-success ',
                        action: function ( e, tObj, node, config ) {
                            $('#fileInput').click()
                        }
                    },
                ],

            });
        });
    </script>
    <script>
        $('#fileInput').on('change', function() {
            let formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('import.excel') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Data berhasil diimport!');
                    $('#myTable').DataTable().ajax.reload(); // Refresh tabel
                },
                error: function(err) {
                    alert('Terjadi kesalahan saat upload.');
                    console.log('Terjadi kesalahan saat upload.',err);
                }
            });
        });
    </script>
</html>
