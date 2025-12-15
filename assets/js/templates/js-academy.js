/**
 * Academy JavaScript
 * Handles Academy header mobile menu and other interactions
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Mobile Menu Toggle
        $('.academy-mobile-menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.academy-mobile-menu').toggleClass('active');
            $('body').toggleClass('academy-menu-open');
        });
        
        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.academy-header').length) {
                $('.academy-mobile-menu-toggle').removeClass('active');
                $('.academy-mobile-menu').removeClass('active');
                $('body').removeClass('academy-menu-open');
            }
        });
        
        // Quiz form validation
        $('#academy-quiz-form').on('submit', function(e) {
            var allAnswered = true;
            var questionCount = $('.quiz-question').length;
            
            // Check if all questions are answered
            for (var i = 0; i < questionCount; i++) {
                var questionName = 'question_' + i;
                if (!$('input[name="' + questionName + '"]:checked').length) {
                    allAnswered = false;
                    $('.quiz-question[data-question-index="' + i + '"]').addClass('error');
                } else {
                    $('.quiz-question[data-question-index="' + i + '"]').removeClass('error');
                }
            }
            
            if (!allAnswered) {
                e.preventDefault();
                alert('Please answer all questions before submitting.');
                $('html, body').animate({
                    scrollTop: $('.quiz-question.error').first().offset().top - 100
                }, 500);
                return false;
            }
            
            // Confirm submission
            if (!confirm('Are you sure you want to submit the quiz? You cannot change your answers after submission.')) {
                e.preventDefault();
                return false;
            }
        });
        
        // Highlight selected option
        $('.option-label input[type="radio"]').on('change', function() {
            $('.option-label').removeClass('selected');
            $(this).closest('.option-label').addClass('selected');
        });
        
        // Progress tracking for chapters (scroll-based)
        if ($('.single-module-post-content').length) {
            var chapterId = $('body').data('chapter-id');
            var moduleId = $('body').data('module-id');
            
            if (chapterId && moduleId) {
                var scrollProgress = 0;
                var lastProgress = 0;
                
                $(window).on('scroll', function() {
                    var windowHeight = $(window).height();
                    var documentHeight = $(document).height();
                    var scrollTop = $(window).scrollTop();
                    
                    scrollProgress = Math.round((scrollTop / (documentHeight - windowHeight)) * 100);
                    
                    // Update progress every 10%
                    if (Math.abs(scrollProgress - lastProgress) >= 10) {
                        lastProgress = scrollProgress;
                        
                        // Send progress update via AJAX
                        $.ajax({
                            url: academyAjax.ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'academy_update_progress',
                                chapter_id: chapterId,
                                module_id: moduleId,
                                progress: scrollProgress,
                                nonce: academyAjax.nonce
                            }
                        });
                    }
                });
            }
        }
        
    });
    
})(jQuery);

