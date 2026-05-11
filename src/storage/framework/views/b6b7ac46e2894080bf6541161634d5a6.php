<?php $__env->startSection('title', $article->title); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <!-- 文章头部 -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo e($article->title); ?></h1>

        <div class="flex items-center gap-4 text-sm text-gray-500">
            <?php if($article->category): ?>
                <a href="<?php echo e(route('home', ['category' => $article->category_id])); ?>"
                   class="text-primary-600 hover:underline">
                    <?php echo e($article->category->name); ?>

                </a>
                <span>·</span>
            <?php endif; ?>
            <time datetime="<?php echo e($article->published_at->toDateString()); ?>">
                <?php echo e($article->published_at->format('Y年m月d日')); ?>

            </time>
            <span>·</span>
            <span><?php echo e($article->view_count); ?> 次阅读</span>
        </div>

        <?php if($article->tags->count()): ?>
            <div class="flex flex-wrap gap-2 mt-4">
                <?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('home', ['tag' => $tag->id])); ?>"
                       class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition">
                        #<?php echo e($tag->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </header>

    <!-- 文章内容 -->
    <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="prose prose-lg max-w-none text-gray-800">
            <?php echo nl2br(e($article->content)); ?>

        </div>
    </article>

    <!-- 文章信息 -->
    <div class="mt-8 py-6 border-t border-gray-200">
        <p class="text-gray-500 text-sm">
            作者：<?php echo e($article->user->name); ?>

            · 发布于 <?php echo e($article->published_at->format('Y-m-d H:i')); ?>

            <?php if($article->updated_at->gt($article->published_at)): ?>
                · 最后更新于 <?php echo e($article->updated_at->format('Y-m-d H:i')); ?>

            <?php endif; ?>
        </p>
    </div>

    <!-- 相关文章 -->
    <?php if($relatedArticles->count()): ?>
        <div class="mt-8">
            <h3 class="font-bold text-gray-900 mb-4">相关文章</h3>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                <?php $__currentLoopData = $relatedArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('article.show', $related->slug)); ?>"
                       class="block px-6 py-4 hover:bg-gray-50 transition">
                        <p class="text-gray-900 hover:text-primary-600"><?php echo e($related->title); ?></p>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e($related->published_at->format('Y-m-d')); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- 返回按钮 -->
    <div class="mt-8">
        <a href="<?php echo e(route('home')); ?>" class="text-primary-600 hover:underline">
            ← 返回首页
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/home/show.blade.php ENDPATH**/ ?>