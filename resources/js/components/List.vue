<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 m-5">
                <a href="/create" class="btn btn-primary mb-4">NOVO</a>
                <table class="table table-striped">
                    <thead>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Ação</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Eduardo</td>
                            <td>eduardo.contiero@hotmail.com</td>
                            <td>(44)99999999</td>
                            <td>
                                <a href="/edit/1" class="btn btn-info">EDITAR</a>
                                <a href="/delete/1" class="btn btn-danger">EXCLUIR</a>
                            </td>
                            
                        </tr>
                        
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
