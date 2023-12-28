<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <p class="mb-4"> Olá {{ Auth::user()->name }}</p>
                </div>

                <div class="p-6 text-gray-900">

                    <table class="table-auto w-full">
                        <thead class="text-left bg-gray-100">
                            <tr>
                                <th class="text-center">Nível</th>
                                <th class="p-4">Nome</th>
                                <th>Email</th>
                                <th>Data de cadastro</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-100">
                                    <td class="text-center">icone</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td class="text-center">
                                        <a href="">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <div class="p-3 bg-gray-100 rounded-lg mb-4">
                            {{ $users->links() }}
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
