<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Pegawai</h1>
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" id="nama" class="form-control" placeholder="Cari Nama">
            </div>
            <div class="col-md-3">
                <select id="jabatan" class="form-control select2">
                    <option value="">Pilih Jabatan</option>
                    <option value="Manager">Manager</option>
                    <option value="Staff">Staff</option>
                    <option value="Supervisor">Supervisor</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" id="tanggal_masuk" class="form-control daterangepicker">
            </div>
            <div class="col-md-3">
                <button id="filter" class="btn btn-primary">Filter</button>
            </div>
        </div>
        <table id="pegawai-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Tanggal Masuk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.daterangepicker').daterangepicker();

        var table = $('#pegawai-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('pegawai.index') }}",
                data: function (d) {
                    d.nama = $('#nama').val();
                    d.jabatan = $('#jabatan').val();
                    d.tanggal_masuk = $('#tanggal_masuk').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'jabatan', name: 'jabatan' },
                { data: 'tanggal_masuk', name: 'tanggal_masuk' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#filter').click(function() {
            table.draw();
        });
    });
    </script>
</body>
</html>