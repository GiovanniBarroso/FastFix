<!-- Modal de Términos y Condiciones --><template>
    <transition name="fade">
        <div v-if="show"
            class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md backdrop-saturate-150 flex items-center justify-center px-4"
           @click.self="$emit('close')">
            <div
                class="relative bg-white text-gray-800 rounded-2xl w-full max-w-3xl p-8 shadow-2xl overflow-y-auto max-h-[90vh] border border-white/10 backdrop-brightness-75">
                <button @click="$emit('close')"
                    class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl">
                    &times;
                </button>
                <div class="mb-6 text-center">
                    <h2 class="text-3xl font-bold text-red-600">Términos y Condiciones</h2>
                    <p class="text-sm text-gray-500">Última actualización: Mayo 2025</p>
                </div>

                <div class="space-y-6 text-gray-700 text-base leading-relaxed">
                    <section>
                        <h3 class="font-bold text-lg text-red-500">1. Aceptación de términos</h3>
                        <p>
                            Al acceder o usar el sitio web de FastFix, aceptas cumplir estos términos y condiciones. Si
                            no estás de
                            acuerdo, por favor no utilices nuestros servicios.
                        </p>
                    </section>

                    <section>
                        <h3 class="font-bold text-lg text-red-500">2. Uso del sitio</h3>
                        <p>
                            El contenido del sitio es solo para uso personal y no comercial. Queda prohibido modificar,
                            distribuir,
                            transmitir o explotar el contenido sin nuestro consentimiento.
                        </p>
                    </section>

                    <section>
                        <h3 class="font-bold text-lg text-red-500">3. Propiedad intelectual</h3>
                        <p>
                            Todos los derechos sobre marcas, logos, diseños y contenidos pertenecen a FastFix. No se
                            permite el uso
                            sin
                            autorización expresa.
                        </p>
                    </section>

                    <section>
                        <h3 class="font-bold text-lg text-red-500">4. Responsabilidad del usuario</h3>
                        <p>
                            Te comprometes a proporcionar información veraz, no realizar actividades ilícitas y respetar
                            la
                            integridad
                            del sitio.
                        </p>
                    </section>

                    <section>
                        <h3 class="font-bold text-lg text-red-500">5. Modificaciones</h3>
                        <p>
                            Nos reservamos el derecho de modificar estos términos en cualquier momento. Te notificaremos
                            cualquier
                            cambio sustancial a través del sitio o por correo electrónico.
                        </p>
                    </section>

                    <section>
                        <h3 class="font-bold text-lg text-red-500">6. Legislación aplicable</h3>
                        <p>
                            Estos términos se rigen por la legislación vigente en España. Cualquier disputa será
                            resuelta por los
                            tribunales competentes de Sevilla.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </transition>
</template>
<script setup>
defineProps({ show: Boolean })
defineEmits(['close'])
</script>