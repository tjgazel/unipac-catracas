<template>
    <div>
        <h4 class="mb-3">
            <i class="fas fa-list"></i> Registros de alunos com alto indice de faltas <br>
            <small>Dias letivos entre as datas selecionadas: <strong v-if="diasLetivos">{{diasLetivos}}</strong><i
                v-else class="fas fa-spinner fa-spin"></i></small>
        </h4>

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
                    <th class="text-center" style="width: 110px;"><i class="fas fa-history"></i> Histórico <br> de
                        presença
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="!alunos.length">
                    <td colspan="9" class="text-center py-5">
                        <i class="fas fa-cog fa-10x fa-spin"></i> <br>
                        Processando...
                    </td>
                </tr>
                <tr v-for="(aluno, index) in alunos" :key="index">
                    <td class="align-middle">{{aluno.credencial}}</td>
                    <td class="align-middle">{{aluno.nome}}</td>
                    <td class="align-middle text-center">{{aluno.periodo}}</td>
                    <td class="align-middle">{{aluno.curso}}</td>
                    <td class="align-middle text-center">{{aluno.fixo}}</td>
                    <td class="align-middle text-center">{{aluno.celular}}</td>
                    <td class="align-middle text-center">{{aluno.faltas}} / {{diasLetivos}}</td>
                    <td :class="['align-middle text-center', { 'bg-warning': aluno.faltas_percentual >= 40 && aluno.faltas_percentual < 60,
                                 'bg-danger': aluno.faltas_percentual >= 60}]">
                        {{aluno.faltas_percentual}}
                    </td>
                    <td class="align-middle text-center">
                        <a :href="'/catracas/' + aluno.credencial"><i class="far fa-paper-plane"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>


    export default {
        props: ['urlAlunos', 'urlAcessos', 'dataForm', 'diasLetivos'],

        data() {
            return {
                loading: false,
                form: JSON.parse(this.dataForm),
                dataAlunos: [],
                alunos: [],
                acessos: [],
            }
        },

        mounted() {
            this.startComponent();
        },

        methods: {
            startComponent() {
                Promise.all([
                    this.getAcessos(),
                    this.getAlunos()
                ])
                    .then(() => this.processaAlunos())
                    .catch(error => console.log(error.response))
            },

            getAlunos(loading = false) {
                loading ? this.loading = true : null;

                let url = this.form.search != '' ? `${this.urlAlunos}?search=${this.form.search}` : this.urlAlunos;

                return axios.get(url)
                    .then(resp => {
                        loading ? this.loading = false : null;
                        this.dataAlunos = resp.data;
                    })
                    .catch(error => {
                        loading ? this.loading = false : null;
                        console.log(error.response);
                    })
            },

            getAcessos(loading = false) {
                loading ? this.loading = true : null;

                return axios.get(`${this.urlAcessos}?start=${this.form.start}&end=${this.form.end}`)
                    .then(resp => {
                        loading ? this.loading = false : null;
                        this.acessos = resp.data;
                    })
                    .catch(error => {
                        loading ? this.loading = false : null;
                        console.log(error.response);
                    })
            },

            processaAlunos() {
                if (this.dataAlunos.length && this.acessos.length && this.diasLetivos) {
                    this.alunos = this.dataAlunos.map(aluno => {
                        let diasPresentes = 0;

                        const acessosAluno = this.acessos.filter(acesso => {
                            return parseInt(acesso.CRED_NUMERO) === parseInt(aluno.credencial);
                        });

                        const diasAcesso = [];
                        acessosAluno.forEach(acesso => {

                            if (!diasAcesso.includes(moment(acesso.MOV_DATAHORA).dayOfYear())) {
                                diasAcesso.push(moment(acesso.MOV_DATAHORA).dayOfYear());
                                diasPresentes++;
                            }
                        });

                        aluno.faltas = +this.diasLetivos - +diasPresentes;
                        if (aluno.faltas > 0) {
                            aluno.faltas_percentual = parseFloat(+aluno.faltas / +this.diasLetivos * 100).toFixed(2);
                        } else {
                            aluno.faltas_percentual = 0;
                        }

                        return aluno;

                    }).filter(aluno => aluno.faltas_percentual >= 40).sort((a, b) => {
                        if (a.faltas_percentual > b.faltas_percentual) {
                            return 1;
                        }
                        if (a.faltas_percentual < b.faltas_percentual) {
                            return -1;
                        }
                        // a must be equal to b
                        return 0;
                    });
                }
            }
        }
    }
</script>
