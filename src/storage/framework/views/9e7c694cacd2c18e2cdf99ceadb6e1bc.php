<?php $__env->startSection('title', '新建文章'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">新建文章</h1>
    <p class="text-gray-500 mt-1">创建一篇新文章</p>
</div>

<form action="<?php echo e(route('admin.articles.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- 主内容区 -->
        <div class="lg:col-span-2 space-y-6">
            <!-- 标题 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">标题 <span class="text-red-500">*</span></label>
                <input type="text"
                       id="title"
                       name="title"
                       value="<?php echo e(old('title')); ?>"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="输入文章标题">
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- URL 别名 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">URL 别名</label>
                <input type="text"
                       id="slug"
                       name="slug"
                       value="<?php echo e(old('slug')); ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="留空则自动生成">
                <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- 摘要 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">摘要</label>
                <textarea id="excerpt"
                          name="excerpt"
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition resize-none"
                          placeholder="文章摘要，显示在列表页"><?php echo e(old('excerpt')); ?></textarea>
                <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- 内容 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">内容 <span class="text-red-500">*</span></label>
                <textarea id="content"
                          name="content"
                          rows="20"
                          required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition font-mono text-sm"
                          placeholder="输入文章内容"><?php echo e(old('content')); ?></textarea>
                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <!-- 侧边栏 -->
        <div class="space-y-6">
            <!-- 发布设置 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">发布设置</h3>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">状态</label>
                    <select id="status"
                            name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition">
                        <option value="draft" <?php echo e(old('status') === 'draft' ? 'selected' : ''); ?>>草稿</option>
                        <option value="published" <?php echo e(old('status') === 'published' ? 'selected' : ''); ?>>发布</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-sky-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-sky-700 focus:ring-4 focus:ring-sky-300 transition">
                    保存文章
                </button>
            </div>

            <!-- 分类 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">分类</h3>
                <select id="category_id"
                        name="category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition">
                    <option value="">-- 选择分类 --</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- 标签 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">标签</h3>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="tags[]"
                                   value="<?php echo e($tag->id); ?>"
                                   <?php echo e(in_array($tag->id, old('tags', [])) ? 'checked' : ''); ?>

                                   class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            <span class="ml-2 text-gray-700"><?php echo e($tag->name); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- 封面图 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">封面图</h3>
                <input type="text"
                       id="cover_image"
                       name="cover_image"
                       value="<?php echo e(old('cover_image')); ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="图片 URL">
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/articles/create.blade.php ENDPATH**/ ?>