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
            <div class="form-group col-sm-12">
                <label>Telefono</label>
                <input 
                    wire:model.lazy="telefono" 
                    maxlength="12"
                    type="text" 
                    class="form-control text-left">
            </div>
            <div class="form-group col-sm-12">
                <label>Email</label>
                <input 
                    wire:model.lazy="email" 
                    maxlength="65"
                    type="text" 
                    class="form-control text-center">
            </div>
            <div class="form-group col-sm-12">
                <label>Logo</label>
                <input 
                    type="file" 
                    class="form-control text-center" 
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
