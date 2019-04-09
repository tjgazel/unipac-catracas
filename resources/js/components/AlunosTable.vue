<template>
    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead>
            <tr>
                <th><i class="far fa-id-card"></i> Credencial</th>
                <th><i class="fas fa-user-graduate"></i> Aluno</th>
                <th class="text-center">Período</th>
                <th>Curso</th>
                <th class="text-center" style="width: 100px;"><i class="fas fa-phone"></i> Fixo</th>
                <th class="text-center" style="width: 100px;"><i class="fas fa-mobile-alt"></i> Celular</th>
                <th class="text-center" style="width: 80px;"><i class="far fa-calendar-times"></i> Faltas</th>
                <th class="text-center" style="width: 80px;"><i class="fas fa-percent"></i> Faltas</th>
                <th class="text-center" style="width: 95px;">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="aluno in alunos" class="small">
                <td class="align-middle">{{credencialToString(aluno.credencial)}}</td>
                <td class="align-middle">{{aluno.nome}}</td>
                <td class="align-middle text-center">{{aluno.periodo}}</td>
                <td class="align-middle">{{aluno.curso}}</td>
                <td class="align-middle text-center">{{aluno.fixo ? aluno.fixo : 'Não cadastrado'}}</td>
                <td class="align-middle text-center">{{aluno.celular ? aluno.celular : 'Não cadastrado'}}</td>
                <td class="align-middle text-center">{{aluno.faltas}} / {{diasLetivos}}</td>
                <td :class="['align-middle text-center', {
                        'bg-warning': aluno.faltas_percentual >= 40 && aluno.faltas_percentual < 60,
                        'bg-danger': aluno.faltas_percentual >= 60
                    }]">
                    {{aluno.faltas_percentual}}%
                </td>
                <td class="align-middle text-center">
                    <a :href="'/catracas/' + aluno.credencial" class="btn btn-outline-secondary btn-sm"
                       title="Histórico de presença">
                        <i class="fas fa-history"></i>
                    </a>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                            data-target="#modalLigacoes" @click="openModal(aluno, aluno.credencial)">
                        <i class="fas fa-headset"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        <modal-ligacoes
            :aluno="aluno"
            :credencial="credencial"
            :dias-letivos="diasLetivos"
            @close-modal="closeModal"></modal-ligacoes>
    </div>
</template>

<script>
    import ModalLigacoes from './ModalLigacoes';

    export default {
        props: ['dataAlunos', 'diasLetivos'],

        components: {ModalLigacoes},

        data() {
            return {
                alunos: JSON.parse(this.dataAlunos),
                aluno: {},
                credencial: null
            }
        },

        methods: {
            openModal(aluno, credencial) {
                this.aluno = aluno;
                this.credencial = this.credencialToString(credencial);
            },

            closeModal() {
                this.aluno = {};
                this.credencial = null;
            },

            credencialToString(credencial) {
                credencial = '' + credencial;
                credencial.length != 12 ? credencial = '0' + credencial : null;

                return '' + credencial;
            }
        }
    }
</script>
