<?php $__env->startSection('title', 'Cadastrar Novo Servidor'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Cadastrar Novo Servidor</h1>
        </div>

        <!-- Formulário de Cadastro -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="<?php echo e(route('servidor.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
                <?php echo csrf_field(); ?>

                <!-- Seção de Dados Pessoais -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-6">Dados Pessoais</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Matrícula -->
                        <div class="md:col-span-1">
                            <label for="matricula" class="block text-sm font-semibold text-gray-700 mb-2">Matrícula</label>
                            <input type="text" id="matricula" name="matricula" value="<?php echo e(old('matricula')); ?>"
                                placeholder="Ex: 123456"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['matricula'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['matricula'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Nome Completo -->
                        <div class="md:col-span-2">
                            <label for="nomeCompleto" class="block text-sm font-semibold text-gray-700 mb-2">Nome
                                Completo</label>
                            <input type="text" id="nomeCompleto" name="nomeCompleto" value="<?php echo e(old('nomeCompleto')); ?>"
                                placeholder="Digite o nome completo"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['nomeCompleto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['nomeCompleto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-semibold text-gray-700 mb-2">CPF</label>
                            <input type="text" id="cpf" name="cpf" value="<?php echo e(old('cpf')); ?>"
                                placeholder="000.000.000-00"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['cpf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['cpf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- RG -->
                        <div>
                            <label for="rg" class="block text-sm font-semibold text-gray-700 mb-2">RG</label>
                            <input type="text" id="rg" name="rg" value="<?php echo e(old('rg')); ?>"
                                placeholder="00.000.000-0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['rg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['rg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Data de Nascimento -->
                        <div>
                            <label for="dataNascimento" class="block text-sm font-semibold text-gray-700 mb-2">Data de
                                Nascimento</label>
                            <input type="date" id="dataNascimento" name="dataNascimento"
                                value="<?php echo e(old('dataNascimento')); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['dataNascimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['dataNascimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Gênero -->
                        <div>
                            <label for="genero" class="block text-sm font-semibold text-gray-700 mb-2">Gênero</label>
                            <select id="genero" name="genero"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['genero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Masculino" <?php if(old('genero') == 'Masculino'): ?> selected <?php endif; ?>>Masculino
                                </option>
                                <option value="Feminino" <?php if(old('genero') == 'Feminino'): ?> selected <?php endif; ?>>Feminino</option>
                            </select>
                            <?php $__errorArgs = ['genero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Estado Civil -->
                        <div>
                            <label for="estadoCivil" class="block text-sm font-semibold text-gray-700 mb-2">Estado
                                Civil</label>
                            <select id="estadoCivil" name="estadoCivil"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['estadoCivil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Solteiro(a)" <?php if(old('estadoCivil') == 'Solteiro(a)'): ?> selected <?php endif; ?>>Solteiro(a)
                                </option>
                                <option value="Casado(a)" <?php if(old('estadoCivil') == 'Casado(a)'): ?> selected <?php endif; ?>>Casado(a)
                                </option>
                                <option value="Divorciado(a)" <?php if(old('estadoCivil') == 'Divorciado(a)'): ?> selected <?php endif; ?>>
                                    Divorciado(a)</option>
                                <option value="Viúvo(a)" <?php if(old('estadoCivil') == 'Viúvo(a)'): ?> selected <?php endif; ?>>Viúvo(a)
                                </option>
                            </select>
                            <?php $__errorArgs = ['estadoCivil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
                            <input type="text" id="telefone" name="telefone" value="<?php echo e(old('telefone')); ?>"
                                placeholder="(00) 00000-0000"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Endereço -->
                        <div class="md:col-span-3">
                            <label for="endereco" class="block text-sm font-semibold text-gray-700 mb-2">Endereço</label>
                            <input type="text" id="endereco" name="endereco" value="<?php echo e(old('endereco')); ?>"
                                placeholder="Rua, Número, Bairro, Cidade - Estado, CEP"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['endereco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['endereco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Raça/Cor -->
                        <div>
                            <label for="racaCor" class="block text-sm font-semibold text-gray-700 mb-2">Raça/Cor</label>
                            <select id="racaCor" name="racaCor"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['racaCor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Selecione a raça/cor</option>
                                <option value="Branca" <?php echo e(old('racaCor') == 'Branca' ? 'selected' : ''); ?>>Branca</option>
                                <option value="Preta" <?php echo e(old('racaCor') == 'Preta' ? 'selected' : ''); ?>>Preta</option>
                                <option value="Parda" <?php echo e(old('racaCor') == 'Parda' ? 'selected' : ''); ?>>Parda</option>
                                <option value="Amarela" <?php echo e(old('racaCor') == 'Amarela' ? 'selected' : ''); ?>>Amarela
                                </option>
                            </select>
                            <?php $__errorArgs = ['racaCor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Tipo Sanguíneo -->
                        <div>
                            <label for="tipoSanguineo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo
                                Sanguíneo</label>
                            <select id="tipoSanguineo" name="tipoSanguineo"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['tipoSanguineo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Selecione o tipo sanguíneo</option>
                                <option value="A+" <?php echo e(old('tipoSanguineo') == 'A+' ? 'selected' : ''); ?>>A+</option>
                                <option value="A-" <?php echo e(old('tipoSanguineo') == 'A-' ? 'selected' : ''); ?>>A-</option>
                                <option value="B+" <?php echo e(old('tipoSanguineo') == 'B+' ? 'selected' : ''); ?>>B+</option>
                                <option value="B-" <?php echo e(old('tipoSanguineo') == 'B-' ? 'selected' : ''); ?>>B-</option>
                                <option value="AB+" <?php echo e(old('tipoSanguineo') == 'AB+' ? 'selected' : ''); ?>>AB+</option>
                                <option value="AB-" <?php echo e(old('tipoSanguineo') == 'AB-' ? 'selected' : ''); ?>>AB-</option>
                                <option value="O+" <?php echo e(old('tipoSanguineo') == 'O+' ? 'selected' : ''); ?>>O+</option>
                                <option value="O-" <?php echo e(old('tipoSanguineo') == 'O-' ? 'selected' : ''); ?>>O-</option>
                            </select>
                            <?php $__errorArgs = ['tipoSanguineo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Foto -->
                        <div>
                            <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">Foto</label>
                            <input type="file" id="foto" name="foto"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Seção de Dados Funcionais -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-6">Dados Funcionais</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Formação -->
                        <div class="md:col-span-2">
                            <label for="formacao" class="block text-sm font-semibold text-gray-700 mb-2">Formação</label>
                            <input type="text" id="formacao" name="formacao" value="<?php echo e(old('formacao')); ?>"
                                placeholder="Ex: Bacharel em Administração"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['formacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['formacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- PIS/PASEP -->
                        <div>
                            <label for="pisPasep" class="block text-sm font-semibold text-gray-700 mb-2">PIS/PASEP</label>
                            <input type="text" id="pisPasep" name="pisPasep" value="<?php echo e(old('pisPasep')); ?>"
                                placeholder="Digite o número do PIS/PASEP"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['pisPasep'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['pisPasep'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Data de Nomeação -->
                        <div>
                            <label for="dataNomeacao" class="block text-sm font-semibold text-gray-700 mb-2">Data de
                                Nomeação</label>
                            <input type="date" id="dataNomeacao" name="dataNomeacao"
                                value="<?php echo e(old('dataNomeacao')); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['dataNomeacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['dataNomeacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Vínculo -->
                        <div>
                            <label for="idVinculo" class="block text-sm font-semibold text-gray-700 mb-2">Vínculo</label>
                            <select id="idVinculo" name="idVinculo"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['idVinculo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Efetivo" <?php echo e(old('idVinculo') == 'Efetivo' ? 'selected' : ''); ?>>Efetivo
                                </option>
                                <option value="Comissionado" <?php echo e(old('idVinculo') == 'Comissionado' ? 'selected' : ''); ?>>
                                    Comissionado</option>
                                <option value="Voluntário" <?php echo e(old('idVinculo') == 'Voluntário' ? 'selected' : ''); ?>>
                                    Voluntário</option>
                                <option value="PVSA" <?php echo e(old('idVinculo') == 'PVSA' ? 'selected' : ''); ?>>PVSA</option>
                            </select>
                            <?php $__errorArgs = ['idVinculo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Lotação -->
                        <div>
                            <label for="idLotacao" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['block', 'text-sm', 'font-semibold', 'text-gray-700', 'mb-2']); ?>">Lotação</label>
                            <select id="idLotacao" name="idLotacao"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['idLotacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="" disabled selected>Selecione...</option>
                                <option value="PM" <?php echo e(old('idLotacao') == 'PM' ? 'selected' : ''); ?>>PM</option>
                                <option value="PC" <?php echo e(old('idLotacao') == 'PC' ? 'selected' : ''); ?>>PC</option>
                                <option value="Politec" <?php echo e(old('idLotacao') == 'Politec' ? 'selected' : ''); ?>>Politec
                                </option>
                                <option value="Bombeiros" <?php echo e(old('idLotacao') == 'Bombeiros' ? 'selected' : ''); ?>>
                                    Bombeiros</option>
                            </select>
                            <?php $__errorArgs = ['idLotacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Seção de Dependentes -->
                <div id="dependentes-section">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Dependentes</h2>
                        <button type="button" onclick="adicionarDependente()" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Adicionar Dependente
                        </button>
                    </div>

                    <div id="dependentes-container" class="space-y-6">
                        <!-- Dependentes serão adicionados aqui -->
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <a href="<?php echo e(route('servidores.index')); ?>"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-semibold transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                        <i class="fas fa-check mr-2"></i>
                        Salvar Servidor
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let contadorDependentes = 0;
        
        function adicionarDependente() {
            contadorDependentes++;
            
            const novoDependente = `
                <div class="dependente-item bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Dependente ${contadorDependentes}</h3>
                        <button type="button" onclick="removerDependente(this)" 
                            class="text-red-600 hover:text-red-800 font-semibold flex items-center">
                            <i class="fas fa-trash mr-1"></i> Remover
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo</label>
                            <input type="text" name="dependentes[${contadorDependentes-1}][nome]" 
                                placeholder="Digite o nome completo"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Parentesco</label>
                            <input type="number" name="dependentes[${contadorDependentes-1}][idade]" 
                                placeholder="Idade" min="0" max="120"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Data de Nascimento</label>
                            <input type="date" name="dependentes[${contadorDependentes-1}][data_nascimento]" 
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">CPF</label>
                            <input type="text" name="dependentes[${contadorDependentes-1}][cpf]" 
                                placeholder="000.000.000-00"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('dependentes-container').insertAdjacentHTML('beforeend', novoDependente);
        }
        
        function removerDependente(botao) {
            botao.closest('.dependente-item').remove();
            // Atualizar números dos dependentes restantes
            const itens = document.querySelectorAll('.dependente-item');
            itens.forEach((item, index) => {
                item.querySelector('h3').textContent = `Dependente ${index + 1}`;
                // Atualizar os índices dos inputs
                const inputs = item.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/\[(\d+)\]/, `[${index}]`);
                    input.setAttribute('name', newName);
                });
            });
            contadorDependentes = itens.length;
        }
        
        // Adicionar primeiro dependente automaticamente
        document.addEventListener('DOMContentLoaded', function() {
            adicionarDependente();
        });
    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/sistema-rh-layouts/resources/views/servidor/colaboradores/create.blade.php ENDPATH**/ ?>