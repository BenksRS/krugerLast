<div>

    <div class="dd m-0">
        <ol class="dd-list">
            @foreach($links as $link)
{{--                                @dump($link)--}}
                <li class="dd-item dd-item-general" data-id="{{ $link->id }}">
                    <div class="card border m-0">
                        <div class="dd-handle border-end"></div>
                        <div class="dd-header">
                            <div class="dd-header-collapse" role="button" aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#link-{{ $link->id }}"></div>
                            <div class="dd-header-title">{{ $link->title }}</div>

                            <div class="dd-header-actions ms-auto me-5 d-flex gap-3">
                                <div class="action-item">
                                    <div class="action-item" wire:click="deleteLink({{ $link }})">
                                        <i class="bx bx-trash text-danger"></i>
                                    </div>
                                    <div class="action-item d-none">
                                        <i class="bx bx-edit text-info"></i>
                                    </div>


                                </div>






                            </div>



                        </div>
                        <div class="border-top dd-body collapse" id="link-{{ $link->id }}">
                            <div class="card-body">
                                @include('menu::build.form.general')
                            </div>
                        </div>

                    </div>
                    @if(!empty($link['children']))
                        <ol class="dd-list">
                            @foreach($link['children'] as $child)

                                <li class="dd-item dd-item-general" data-id="{{ $child->id }}">
                                    <div class="card border m-0">
                                        <div class="dd-handle border-end"></div>
                                        <div class="dd-header">
                                            <div class="dd-header-collapse" role="button" aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#link-{{ $child->id }}"></div>
                                            <div class="dd-header-title">{{ $child->title }}</div>
                                            <div class="dd-header-actions ms-auto me-5 d-flex gap-3">
                                                <div class="action-item">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="active-in1-{{ $child->id }}" {{ (($child->group->visible ?? 0) == 1) ? 'checked' : ' '}}  wire:change="updateItemGroup({{$child}})">
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="border-top dd-body collapse" id="link-{{ $child->id }}">
                                            <div class="card-body">
                                                @include('menu::build.form.general')
                                            </div>
                                        </div>

                                    </div>
                                </li>




                            @endforeach
                        </ol>
                    @endif
                </li>

            @endforeach
        </ol>
    </div>
</div>
