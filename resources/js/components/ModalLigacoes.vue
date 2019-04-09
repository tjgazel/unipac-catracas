<template>
    <div class="modal fade" id="modalLigacoes" tabindex="-1" role="dialog" aria-labelledby="modalLigacoesLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLigacoesLabel">{{aluno.nome}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{aluno.faltas}} faltas em {{diasLetivos}} dias letivos. <br>
                        <i class="fas fa-phone"></i> {{aluno.fixo ? aluno.fixo : 'Não cadastrado'}} |
                        <i class="fas fa-mobile-alt"></i> {{aluno.celular ? aluno.celular : 'Não cadastrado'}}
                    </p>
                    <div class="form-group">
                        <label>Status da tentativa de contato</label>
                        <select v-model="form.status" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="A">Atendeu</option>
                            <option value="N">Não atendeu</option>
                            <option value="J">Faltas Justificadas</option>
                            <option value="T">Telefones desatualizados</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status da tentativa de contato</label>
                        <textarea v-model="form.observacao" rows="1" class="form-control"></textarea>
                        <span v-if="form.observacao.length > 191" class="small text-danger">Máximo de caracteres excedidos</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary float-right"
                                :disabled="btnDisabled" @click="save"><i class="fas fa-save"></i> Salvar
                        </button>
                    </div>
                    <div v-if="ligacoes.length">
                        <h5 class="mt-3"><i class="fas fa-clock"></i> Histórico de ligações</h5>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Operador</th>
                                <th>Data - Hora</th>
                                <th>status</th>
                                <th>Observações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="ligacao in ligacoes">
                                <td>{{ligacao.user.name}}</td>
                                <td>{{ligacao.created_at | dataHora}}</td>
                                <td>{{statusToString(ligacao.status)}}</td>
                                <td>{{ligacao.observacao}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['aluno', 'credencial', 'diasLetivos'],

        data() {
            return {
                loading: false,
                form: {
                    credencial: this.credencial,
                    status: '',
                    observacao: ''
                },
                ligacoes: []
            }
        },

        computed: {
            btnDisabled() {
                return this.form.status == '' || this.form.observacao.length > 191;
            }
        },

        watch: {
            credencial: function (newValue, oldValue) {
                if (newValue != oldValue) {
                    this.form.credencial = newValue
                    this.getLigacoes();
                }
            }
        },

        mounted() {
            $('#modalLigacoes').on('hide.bs.modal', (e) => {
                this.$emit('close-modal');
            })
        },

        methods: {
            getLigacoes() {
                this.loading = true;
                axios.get('/catracas/relatorios/ligacoes', {
                    params: {
                        credencial: this.credencial
                    }
                })
                    .then(resp => {
                        this.loading = false;
                        this.ligacoes = resp.data;
                        this.handleUpdate();
                    })
                    .catch(error => console.log(error.response))
            },

            save() {
                axios.post('/catracas/relatorios/ligacoes', this.form)
                    .then(resp => {
                        this.getLigacoes();
                        this.resetForm();
                    })
                    .catch(error => console.log(error.response))
            },

            resetForm() {
                this.form = {...this.form, observacao: '', status: ''};
            },

            handleUpdate() {
                $('#modalLigacoes').modal('handleUpdate');
            },

            statusToString(status) {
                switch (status) {
                    case 'A':
                        return 'Atendeu';
                    case 'N':
                        return 'Não Atendeu';
                    case 'J':
                        return 'Faltas Justificadas';
                    case 'T':
                        return 'Telefones desatualizados';
                    default:
                        return '';
                }
            }
        },

        filters: {
            dataHora(value) {
                if (!value) return '';
                if (value) {
                    return window.moment(String(value)).format('DD/MM/YYYY - HH:mm')
                }
            }
        }

    }
</script>
