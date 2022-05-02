<template>
    <div class="container">
        <div class="row justify-content-center">
            <loading :active.sync="isLoading" :is-full-page="true"></loading>
            <div class="col-md-12 m-5">
                <a href="/" class="btn btn-primary mb-4">VOLTAR</a>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#home"
                            type="button"
                            role="tab"
                            aria-controls="home"
                            aria-selected="true"
                        >
                            Etapa 1
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#profile"
                            type="button"
                            role="tab"
                            aria-controls="profile"
                            aria-selected="false"
                        >
                            Etapa 2
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#contact"
                            type="button"
                            role="tab"
                            aria-controls="contact"
                            aria-selected="false"
                        >
                            Etapa 3
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div
                        class="tab-pane active"
                        id="home"
                        role="tabpanel"
                        aria-labelledby="home-tab"
                    >
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    v-model="user.name"
                                    placeholder="Nome Completo"
                                />
                                <div class="text-danger" v-if="errors.name">
                                    {{ errors.name[0] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    v-model="user.email"
                                />
                                <div class="text-danger" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    v-model="user.phone"
                                />
                                <div class="text-danger" v-if="errors.phone">
                                    {{ errors.phone[0] }}
                                </div>
                            </div>

                            <button
                                type="button"
                                class="btn btn-primary mt-2"
                                @click="_saveUser()"
                            >
                                Salvar e continuar
                            </button>
                        </form>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="profile"
                        role="tabpanel"
                        aria-labelledby="profile-tab"
                    >
                        <h5>Qualificações profissionais</h5>
                        <button
                            class="btn btn-primary"
                            @click="addProfessionalQualification"
                        >
                            Adicionar
                        </button>
                        <div
                            class="mt-3 mb-3"
                            v-for="(
                                value, counter
                            ) in professional_qualifications"
                            v-bind:key="'P' + counter"
                        >
                            <input
                                type="email"
                                class="form-control"
                                name="name"
                                v-model="value.description"
                                placeholder="Nome Completo"
                            />
                        </div>

                        <h5 class="mt-3">Qualificações acadêmicas</h5>
                        <button
                            class="btn btn-primary"
                            @click="addAcademicQualification"
                        >
                            Adicionar
                        </button>
                        <div
                            class="mt-3 mb-3"
                            v-for="(value, counter) in academic_qualifications"
                            :key="'A' + counter"
                        >
                            <input
                                type="email"
                                class="form-control"
                                name="name"
                                v-model="value.description"
                                placeholder="Nome Completo"
                            />
                        </div>

                        <button
                            type="button"
                            class="btn btn-primary mt-3"
                            :disabled="!user.id"
                            @click="_saveQualifications()"
                        >
                            Salvar e continuar
                        </button>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="contact"
                        role="tabpanel"
                        aria-labelledby="contact-tab"
                    >
                        <form method="post" class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Usuário</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="name"
                                    v-model="user.username"
                                    placeholder="Nome Completo"
                                />
                                <div class="text-danger" v-if="errors.username">
                                    {{ errors.username[0] }}
                                </div>
                                <label class="form-label">Senha</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    v-model="user.password"
                                    placeholder="Senha"
                                />
                                <div class="text-danger" v-if="errors.password">
                                    {{ errors.password[0] }}
                                </div>
                                 <label class="form-label">Confirmar Senha</label>
                            <input
                                type="password"
                                class="form-control"
                                name="password_confirmation"
                                v-model="user.password_confirmation"
                                placeholder="Confirmar Senha"
                            />
                            <div class="text-danger" v-if="errors.password">
                                {{ errors.password[1] }}
                            </div>

                            <button
                                type="button"
                                class="btn btn-primary mt-3"
                                :disabled="!user.id"
                                @click="_saveUser()"
                            >
                                Salvar e continuar
                            </button>
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import { sendRequest } from "../functions.js";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
    components: { Loading },
    data: function () {
        return {
            user: {},
            errors: [],
            isLoading: false,
            professional_qualifications: [
                {
                    description: "",
                    type: "PROFISSIONAL",
                },
            ],
            academic_qualifications: [
                {
                    description: "",
                    type: "ACADEMICO",
                },
            ],
        };
    },
    methods: {
        _saveUser() {
            this.isLoading = true;
            sendRequest("/save", this.user)
                .then((response) => {
                   
                        this.isLoading = false;
                        this.user = response.data.user;
                        if(response.data.user.username != null){
                            window.location.href = '/';
                        }else{
                             this.nextTab();
                        }
                       
                })
                .catch((error) => {
                    this.isLoading = false;

                    this.errors = error.response.data.errors;
                    console.log(this.errors);
                });
        },
        _saveQualifications() {
            this.isLoading = true;
            sendRequest(`${this.user.id}/qualifications/save`, {
                professional_qualifications: this.professional_qualifications,
                academic_qualifications: this.academic_qualifications,
            })
                .then((response) => {
                    this.isLoading = false;
                    this.nextTab();
                    
                  
                })
                .catch((error) => {
                    this.isLoading = false;

                  this.errors = error.response.data.errors;
                  console.log(this.errors);
                });
        },
        addProfessionalQualification() {
            this.professional_qualifications.push({
                description: "",
                type: "PROFISSIONAL",
            });
        },
        addAcademicQualification() {
            this.academic_qualifications.push({
                description: "",
                type: "ACADEMICO",
            });
        },
        nextTab() {
            let $active = $(".nav-tabs li>button.active");

            $($active)
                .parent()
                .next()
                .find('button[data-bs-toggle="tab"]')
                .click();
        },
    },
    mounted() {
        console.log("Create mounted.");
    },
};
</script>
