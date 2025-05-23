<template>
    <transition name="fade">
        <div v-if="show"
            class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md backdrop-saturate-150 flex items-center justify-center px-4"
            @click.self="$emit('close')">
            <div
                class="relative bg-white text-gray-800 rounded-2xl w-full max-w-3xl p-8 shadow-2xl overflow-y-auto max-h-[90vh]">

                <button @click="$emit('close')"
                    class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl">&times;</button>

                <div class="mb-6 text-center">
                    <h2 class="text-3xl font-bold text-red-600">Política de Privacidad</h2>
                    <p class="text-sm text-gray-500">Última actualización: Mayo 2025</p>
                </div>

                <div class="space-y-6 text-gray-700 text-base leading-relaxed">
                    <section>
                        <h3 class="font-bold text-lg text-red-500">1. Recopilación de información</h3>
                        <p>Recopilamos datos personales como nombre, correo electrónico, teléfono, dirección y métodos
                            de pago al registrarte, contactarnos o realizar compras.</p>
                    </section>
                    <section>
                        <h3 class="font-bold text-lg text-red-500">2. Uso de la información</h3>
                        <p>Utilizamos tus datos para procesar pedidos, ofrecer soporte, personalizar tu experiencia y
                            enviarte notificaciones relevantes. No los usamos para fines no autorizados.</p>
                    </section>
                    <section>
                        <h3 class="font-bold text-lg text-red-500">3. Protección de datos</h3>
                        <p>Usamos medidas de seguridad técnicas y organizativas, incluyendo cifrado SSL, firewalls y
                            acceso limitado, para proteger tu información contra accesos no autorizados.</p>
                    </section>
                    <section>
                        <h3 class="font-bold text-lg text-red-500">4. Compartición de datos</h3>
                        <p>No vendemos tu información. Solo compartimos con terceros que nos ayudan a proveer el
                            servicio, como procesadores de pago, bajo estrictos acuerdos de confidencialidad.</p>
                    </section>
                    <section>
                        <h3 class="font-bold text-lg text-red-500">5. Uso de cookies</h3>
                        <p>Empleamos cookies para analizar tráfico, mejorar tu experiencia y recordar tus preferencias.
                            Puedes gestionarlas desde la configuración de tu navegador.</p>
                    </section>
                    <section>
                        <h3 class="font-bold text-lg text-red-500">6. Derechos del usuario</h3>
                        <p>Puedes acceder, modificar, eliminar o limitar el uso de tus datos. También puedes ejercer tu
                            derecho a la portabilidad o presentar reclamaciones ante la autoridad competente.</p>
                    </section>
                    <section>
                        <h3 class="font-bold text-lg text-red-500">7. Conservación de datos</h3>
                        <p>Guardamos tus datos solo durante el tiempo necesario para cumplir con fines legales, fiscales
                            y contractuales. Pasado este tiempo, los eliminamos de forma segura.</p>
                    </section>
                    <section>
                        <h3 class="font-bold text-lg text-red-500">8. Modificaciones</h3>
                        <p>Nos reservamos el derecho a actualizar esta política. Te informaremos de cambios importantes
                            a través de nuestro sitio web o por email.</p>
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
