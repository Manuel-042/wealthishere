document.addEventListener('DOMContentLoaded', function() {
  const faqItems = document.querySelectorAll('.faq-item');
  const tabBtns = document.querySelectorAll('.tab-btn');
  const faqLists = document.querySelectorAll('.faq-list');
  
  // FAQ accordion functionality
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    
    question.addEventListener('click', () => {
      // Close all other items
      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.querySelector('.faq-answer').style.maxHeight = null;
          otherItem.classList.remove('active');
        }
      });
      
      // Toggle current item
      const answer = item.querySelector('.faq-answer');
      item.classList.toggle('active');
      
      if (item.classList.contains('active')) {
        answer.style.maxHeight = answer.scrollHeight + 'px';
      } else {
        answer.style.maxHeight = null;
      }
    });
  });
  
  // Tab switching functionality
  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const tabId = btn.getAttribute('data-tab');
      
      // Update active tab button
      tabBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      
      // Show corresponding FAQ list
      faqLists.forEach(list => {
        list.classList.remove('active');
        if (list.id === `${tabId}-faq`) {
          list.classList.add('active');
        }
      });
    });
  });
});