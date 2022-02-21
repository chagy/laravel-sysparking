<div class="widget-content-area">
    <div class="widget-one">
        <div class="row">
            @include('common.messages')

            <div class="col-12">
                <h4 class="text-center">Datos de la Empresa</h4>
            </div>

            <div class="form-group col-sm-12">
                <label>Nombre</label>
                <input 
                    wire:model.lazy="nombre" 
                    type="text" 
                    class="form-control text-left">
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Telefono</label>
                <input 
                    wire:model.lazy="telefono" 
                    maxlength="12"
                    type="text" 
                    class="form-control text-left">
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Email</label>
                <input 
                    wire:model.lazy="email" 
                    maxlength="65"
                    type="text" 
                    class="form-control text-center">
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Logo</label>
                <input 
                    type="file" 
                    class="form-control text-center" 
                    wire:change="$emit('fileChoosen',this)" 
                    accept="image/x-png,image/gif,image/jpeg" 
                    id="image">
            </div>
            <div class="form-group col-sm-12">
                <label>Direccion</label>
                <input 
                    wire:model.lazy="direccion" 
                    type="text" 
                    class="form-control text-center">
            </div>

            <div class="col-sm-12">
                <button 
                    type="button" 
                    wire:click.prevent="Guardar" 
                    class="btn btn-primary ml-2">
                    <i class="mbri-success"></i> 
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded',function(){
        window.livewire.on('fileChoosen',() => {
            let inputField = document.getElementById('image')
            let file = inputField.files[0]
            let reader = new FileReader()
            reader.onloadend = () => {
                window.livewire.emit("logoUpload",reader.result);
            }
            reader.readAsDataURL(file)
        })
    })

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