<div class="widget-content-area">
    <div class="widget-one">
        @include('common.messages')

        <div class="row">
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Nombre</label>
                <input 
                    type="text" 
                    wire:model.lazy="nombre" 
                    class="form-control" 
                    placeholder="nombre" />
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Telefono</label>
                <input 
                    type="text" 
                    wire:model.lazy="telefono" 
                    class="form-control" 
                    placeholder="telefono" 
                    maxlength="10"/>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Movil</label>
                <input 
                    type="text" 
                    wire:model.lazy="movil" 
                    class="form-control" 
                    placeholder="movil" 
                    maxlength="10"/>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Email</label>
                <input 
                    type="text" 
                    wire:model.lazy="email" 
                    class="form-control" 
                    placeholder="email@mail.com" />
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Tipo</label>
                <select wire:model="tipo" class="form-control text-center">
                    <option value="Elegir">Elegir</option>
                    <option value="Admin">Admin</option>
                    <option value="Empleado">Empleado</option>
                </select>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Password</label>
                <input type="password" wire:model.lazy="password" class="form-control" placeholder="contrasena">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Direccion</label>
                <input 
                    type="text" 
                    wire:model.lazy="direccion" 
                    class="form-control" 
                    placeholder="direccion..." />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mt-2 text-left">
                <button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
                    <i class="mbri-left"></i> Regresar
                </button>
                <button wire:click.prevent="StoreOrUpdate()" class="btn btn-parimary ml-2">
                    <i class="mbri-success"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>