<div class="row layout-top-spacing">
    <div class="col-sm-12 col-md-12 col-lg-12 layout-spacing">

        @if($action == 1)
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h5><b>Cajones de Estacionamiento</b></h5>
                    </div>
                </div>
            </div>
            
            @include('common.search')

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DESCRIPCION</th>
                            <th>ESTATUS</th>
                            <th>TIPO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($info as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->descripcion }}</td>
                            <td>{{ $r->estatus }}</td>
                            <td>{{ $r->tipo }}</td>
                            <td class="text-center">
                                @include('common.actions')
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$info->links()}}
            </div>
        </div>

        @elseif($action == 2)

            @include('livewire.cajones.form')

        @endif

    </div>
</div>

<script>
    function Confirm(id)
    {       
        swal({
            title: 'CONFIRMAR',
            text: '¿DESEAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: false
        },
        function() {        
            window.livewire.emit('deleteRow', id)    
        // toastr.success('info', 'Registro eliminado con éxito')
            swal.close()   
        });
    }
</script>
    