<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Template') }}
        </x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div class="flex justify-between">
            <x-button.link :href="route('template.create')">
                {{ __('Add a new subscriber') }}
            </x-button.link>

            <x-form :action="route('template.index')" x-data x-ref="form" class="w-3/5 flex space-x-4 items-center" flat>
                <x-input.checkbox value="1" name="withTrashed" :label="__('Show Delete Records')" @click="$refs.form.submit()"
                    :checked="$withTrashed" />
                <x-input.text name="search" :placeholder="__('Search')" :value="$search" class="w-full" />
            </x-form>
        </div>

        <x-table :headers="['#', __('Name'), __('Actions')]">
            <x-slot name="body">
                @foreach ($templates as $template)
                    <tr>
                        <x-table.td>{{ $template->id }}</x-table.td>
                        <x-table.td>{{ $template->name }}</x-table.td>
                        <x-table.td class="flex itens-center space-x-4">
                            <x-button.link secondary :href="route('template.edit', $template)">Edit</x-button.link>
                            @unless ($template->trashed())
                                <x-form :action="route('template.destroy', $template)" delete flat
                                    onsubmit=" return confirm('{{ __('Are you sure?') }}')">
                                    <x-button.secondary type="submit">Delete</x-button.secondary>
                                </x-form>
                            @else
                                <x-badge warning>
                                    {{ __('Deleted') }}
                                </x-badge>
                            @endunless
                        </x-table.td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
        {{ $templates->links() }}
    </x-card>
</x-layouts.app>
