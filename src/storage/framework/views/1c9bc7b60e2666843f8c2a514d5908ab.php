<?php $__env->startSection('title', '首页'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col lg:flex-row gap-8">
    <!-- 文章列表 -->
    <div class="flex-1">
        <?php if($categoryId || $tagId): ?>
            <div class="mb-6 pb-4 border-b border-gray-200">
                <p class="text-gray-600">
                    <?php if($categoryId): ?>
                        分类：<span class="font-medium text-gray-900"><?php echo e($categories->firstWhere('id', $categoryId)?->name); ?></span>
                    <?php endif; ?>
                    <?php if($tagId): ?>
                        标签：<span class="font-medium text-gray-900"><?php echo e($tags->firstWhere('id', $tagId)?->name); ?></span>
                    <?php endif; ?>
                    <a href="<?php echo e(route('home')); ?>" class="ml-4 text-sm text-primary-600 hover:underline">清除筛选</a>
                </p>
            </div>
        <?php endif; ?>

        <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 hover:shadow-md transition">
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
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

                <h2 class="text-xl font-bold mb-3">
                    <a href="<?php echo e(route('article.show', $article->slug)); ?>"
                       class="text-gray-900 hover:text-primary-600 transition">
                        <?php echo e($article->title); ?>

                    </a>
                </h2>

                <?php if($article->excerpt): ?>
                    <p class="text-gray-600 mb-4 line-clamp-2"><?php echo e($article->excerpt); ?></p>
                <?php endif; ?>

                <?php if($article->tags->count()): ?>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('home', ['tag' => $tag->id])); ?>"
                               class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition">
                                #<?php echo e($tag->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-16">
                <p class="text-gray-500">暂无文章</p>
            </div>
        <?php endif; ?>

        <!-- 分页 -->
        <div class="mt-8">
            <?php echo e($articles->withQueryString()->links()); ?>

        </div>
    </div>

    <!-- 侧边栏 -->
    <aside class="lg:w-72 space-y-6">
        <!-- 分类列表 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4">分类</h3>
            <ul class="space-y-2">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route('home', ['category' => $category->id])); ?>"
                           class="flex justify-between text-gray-600 hover:text-primary-600 transition
                                  <?php echo e($categoryId == $category->id ? 'text-primary-600 font-medium' : ''); ?>">
                            <span><?php echo e($category->name); ?></span>
                            <span class="text-gray-400"><?php echo e($category->published_articles_count); ?></span>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <!-- 标签云 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4">标签</h3>
            <div class="flex flex-wrap gap-2">
                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('home', ['tag' => $tag->id])); ?>"
                       class="text-sm px-3 py-1 rounded-full transition
                              <?php echo e($tagId == $tag->id
                                  ? 'bg-primary-500 text-white'
                                  : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>">
                        <?php echo e($tag->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </aside>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/home/index.blade.php ENDPATH**/ ?>