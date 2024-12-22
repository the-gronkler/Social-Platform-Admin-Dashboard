<x-layout title="Server List" header="SERVER LIST">
    <x-slot:buttons>
        <a href="create.html" class="button-success">New Server</a>
        <a href="../users/index.html"  class="button-primary" >View All Users</a>
    </x-slot:buttons>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Members</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td>1</td>
            <td>Server 1</td>
            <td>10 / 20</td>
            <td><a href="show.html" class="button-primary" >View Details</a></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Server 2</td>
            <td>15 / 30</td>
            <td><a href="show.html" class="button-primary" >View Details</a></td>
        </tr>
        </tbody>
    </table>

</x-layout>
