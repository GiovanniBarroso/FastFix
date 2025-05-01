<?php $__env->startSection('title', 'Registro'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- 🟠 Tarjeta de Registro -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-warning text-dark fw-bold text-center fs-4 rounded-top-4">
                        <i class="fas fa-user-plus"></i> Crear una Cuenta
                    </div>

                    <div class="card-body p-4">
                        <!-- 🔑 Formulario de Registro -->
                        <form method="POST" action="<?php echo e(route('register')); ?>">
                            <?php echo csrf_field(); ?>

                            <!-- 📌 Nombre -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-brown">
                                    <i class="fas fa-user"></i> Nombre
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-secondary">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="name" type="text"
                                        class="form-control custom-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                                        value="<?php echo e(old('name')); ?>" required autocomplete="name">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- 📌 Apellidos -->
                            <div class="mb-4">
                                <label for="apellidos" class="form-label fw-semibold text-brown">
                                    <i class="fas fa-user"></i> Apellidos
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-secondary">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="apellidos" type="text"
                                        class="form-control custom-input <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="apellidos" value="<?php echo e(old('apellidos')); ?>" required>
                                    <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- 📌 Correo Electrónico -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold text-brown">
                                    <i class="fas fa-envelope"></i> Correo Electrónico
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-secondary">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email"
                                        class="form-control custom-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- 📌 Contraseña -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold text-brown">
                                    <i class="fas fa-lock"></i> Contraseña
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-secondary">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input id="password" type="password"
                                        class="form-control custom-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="password" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- 📌 Confirmar Contraseña -->
                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-semibold text-brown">
                                    <i class="fas fa-lock"></i> Confirmar Contraseña
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-secondary">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control custom-input"
                                        name="password_confirmation" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="password-confirm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- 🟡 Botón de Registro -->
                            <div class="text-center">
                                <button type="submit"
                                    class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm btn-register">
                                    <i class="fas fa-user-plus"></i> Registrarse
                                </button>
                            </div>

                            <!-- 🔗 Ya tienes cuenta? -->
                            <div class="text-center mt-3">
                                <a class="text-decoration-none text-brown fw-bold" href="<?php echo e(route('login')); ?>">
                                    <i class="fas fa-sign-in-alt"></i> ¿Ya tienes cuenta? Inicia sesión
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🌟 Estilos Personalizados -->
    <style>
        .custom-input {
            background: #fff;
            border: 2px solid #ced4da;
            border-radius: 10px;
            padding: 12px;
            transition: all 0.3s ease-in-out;
        }

        .custom-input:focus {
            border-color: #ff9800;
            box-shadow: 0 0 10px rgba(255, 152, 0, 0.5);
            outline: none;
        }

        .btn-register {
            transition: all 0.3s ease-in-out;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #ff9800, #ff5722);
            color: white;
            transform: scale(1.05);
        }
    </style>

    <!-- 🟢 Script para Mostrar/Ocultar Contraseña -->
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                if (input.type === "password") {
                    input.type = "text";
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    input.type = "password";
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Giovanni\Desktop\FastFix\backend\resources\views/auth/register.blade.php ENDPATH**/ ?>