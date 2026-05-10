<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            <?php if($paginator->onFirstPage()): ?>
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                    上一页
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500">
                    上一页
                </a>
            <?php endif; ?>

            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500">
                    下一页
                </a>
            <?php else: ?>
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                    下一页
                </span>
            <?php endif; ?>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    显示第 <span class="font-medium"><?php echo e($paginator->firstItem()); ?></span> 至 <span class="font-medium"><?php echo e($paginator->lastItem()); ?></span> 条，共 <span class="font-medium"><?php echo e($paginator->total()); ?></span> 条
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    
                    <?php if($paginator->onFirstPage()): ?>
                        <span aria-disabled="true" aria-label="上一页">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:text-gray-400" aria-label="上一页">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if(is_string($element)): ?>
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default"><?php echo e($element); ?></span>
                            </span>
                        <?php endif; ?>

                        
                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-sky-600 border border-sky-600 cursor-default"><?php echo e($page); ?></span>
                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:text-gray-500" aria-label="Go to page <?php echo e($page); ?>">
                                        <?php echo e($page); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($paginator->hasMorePages()): ?>
                        <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:text-gray-400" aria-label="下一页">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php else: ?>
                        <span aria-disabled="true" aria-label="下一页">
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>