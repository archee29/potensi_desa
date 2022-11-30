<a href="{{ route('tentangdesa.edit', $tentangdesa) }}" class="btn btn-warning btn-sm">Edit Data</a>
<button href="{{ route('tentangdesa.destroy', $tentangdesa) }}" class="btn btn-danger btn-sm" id="delete">Hapus
    Data</button>
<a href="{{ route('tentangdesa.show', $tentangdesa) }}" class="btn btn-info btn-sm">Show</a>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- isi dari file view action.space sama dengan file view action.centrepoint --}}

<script>
    $('button#delete').on('click', function(e) {
        e.preventDefault();

        var href = $(this).attr('href');

        Swal.fire({
            title: 'Hapus Data Ini?',
            text: "Perhatian data yang sudah di hapus tidak bisa di kembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal!'
        }).then((result) => {
            if (result.isConfirmed) {

                document.getElementById('deleteForm').action = href;
                document.getElementById('deleteForm').submit();

                Swal.fire(
                    'Terhapus!',
                    'Data sudah terhapus.',
                    'success'
                )
            }
        })
    });
</script>
