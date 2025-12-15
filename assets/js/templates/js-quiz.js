/**
 * Academy Quiz JavaScript
 * Handles one-question-at-a-time navigation, auto-save, and progress tracking
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        if (typeof academyQuizData === 'undefined') {
            return; // Quiz data not available
        }
        
        var quizData = academyQuizData;
        var currentQuestion = quizData.currentQuestion;
        
        // Auto-save answer when user selects an option
        $('.option-label input[type="radio"]').on('change', function() {
            var questionIndex = $(this).closest('.quiz-question-wrapper').data('question-index');
            var selectedValue = $(this).val();
            var optionLabel = $(this).closest('.option-label');
            
            // Update UI
            $('.option-label').removeClass('selected');
            optionLabel.addClass('selected');
            
            // Auto-save answer via AJAX
            saveQuizAnswer(questionIndex, selectedValue);
        });
        
        // Save answer function
        function saveQuizAnswer(questionIndex, answer) {
            $.ajax({
                url: quizData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'academy_save_quiz_answer',
                    nonce: quizData.nonce,
                    quiz_id: quizData.quizId,
                    question_index: questionIndex,
                    user_answer: answer
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Answer saved for question ' + (questionIndex + 1));
                    }
                },
                error: function() {
                    console.error('Failed to save answer');
                }
            });
        }
        
        // Navigation buttons - NO JavaScript handler needed
        // Links have proper href attributes and will navigate naturally
        // Browser will handle the navigation automatically
        
        // Submit quiz
        $('#quiz-final-submit').on('click', function(e) {
            e.preventDefault();
            
            // Collect all answers (submit directly without confirmation)
            var allAnswers = {};
            for (var i = 0; i < quizData.totalQuestions; i++) {
                var answer = $('input[name="question_' + i + '"]:checked').val();
                if (answer) {
                    allAnswers[i] = answer;
                }
            }
            
            // Submit form
            var form = $('<form>', {
                'method': 'POST',
                'action': quizData.ajaxUrl.replace('admin-ajax.php', 'admin-post.php')
            });
            
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'action',
                'value': 'academy_quiz_submit'
            }));
            
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'quiz_id',
                'value': quizData.quizId
            }));
            
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'nonce',
                'value': quizData.nonce
            }));
            
            // Add all answers
            $.each(allAnswers, function(index, answer) {
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'question_' + index,
                    'value': answer
                }));
            });
            
            $('body').append(form);
            form.submit();
        });
        
        // Keyboard navigation - navigate directly via URL
        $(document).on('keydown', function(e) {
            // Don't interfere with typing in inputs
            if ($(e.target).is('input, textarea')) {
                return;
            }
            
            // Arrow keys for navigation
            if (e.key === 'ArrowLeft' && currentQuestion > 0) {
                var prevUrl = quizData.quizUrl + '?quiz=1&q=' + (currentQuestion - 1) + '#quiz-content';
                window.location.href = prevUrl;
            } else if (e.key === 'ArrowRight' && currentQuestion < quizData.totalQuestions - 1) {
                var nextUrl = quizData.quizUrl + '?quiz=1&q=' + (currentQuestion + 1) + '#quiz-content';
                window.location.href = nextUrl;
            }
        });
        
    });
    
})(jQuery);

