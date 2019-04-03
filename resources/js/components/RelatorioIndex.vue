<template>
    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead>
            <tr>
                <th><i class="far fa-id-card"></i> Credencial</th>
                <th><i class="fas fa-user-graduate"></i> Aluno</th>
                <th class="text-center">Período</th>
                <th>Curso</th>
                <th class="text-center"><i class="fas fa-phone"></i> Fixo</th>
                <th class="text-center"><i class="fas fa-mobile-alt"></i> Celular</th>
                <th class="text-center" style="width: 100px;"><i class="far fa-calendar-times"></i> Faltas</th>
                <th class="text-center" style="width: 100px;"><i class="fas fa-percent"></i> Faltas</th>
                <th class="text-center" style="width: 110px;"><i class="fas fa-history"></i> Histórico <br> de presença</th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td class="align-middle"></td>
                <td class="align-middle"></td>
                <td class="align-middle text-center"></td>
                <td class="align-middle"></td>
                <td class="align-middle text-center"></td>
                <td class="align-middle text-center"></td>
                <td class="align-middle text-center"></td>
                <td class="align-middle text-center @if($aluno->faltas_percentual >= 40 && $aluno->faltas_percentual < 60)
                                bg-warning @endif @if($aluno->faltas_percentual >= 60) bg-danger text-white @endif">

                </td>
                <td class="align-middle text-center">
                    <a href=""><i class="far fa-paper-plane"></i></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['data', 'dateStart', 'dateEnd', 'urlCalendario'],
        data() {
            return {
                alunos: JSON.parse(this.data).aluno,
                acessos: JSON.parse(this.data).acessos,
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
