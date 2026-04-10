
<div style="max-width: 640px; margin: 1.5rem auto; padding: 0 1rem; position: absolute; " id="policy" class="d-none">

  <div style="background: var(--color-background-primary); border: 0.5px solid var(--color-border-tertiary); border-radius: var(--border-radius-lg); padding: 1.5rem 1.75rem; margin-bottom: 1.25rem; max-height: 320px; overflow-y: auto;">
    <p style="font-size: 13px; font-weight: 500; color: var(--color-text-secondary); margin: 0 0 1rem; text-transform: uppercase; letter-spacing: 0.05em;">Terms and Conditions</p>

    <p style="font-size: 14px; font-weight: 500; color: var(--color-text-primary); margin: 0 0 0.4rem;">1. Acceptance of Terms</p>
    <p style="font-size: 13px; color: var(--color-text-secondary); line-height: 1.6; margin: 0 0 1rem;">By accessing or using our services, you agree to be bound by these Terms and Conditions. If you do not agree to all the terms stated here, please do not use our services.</p>

    <p style="font-size: 14px; font-weight: 500; color: var(--color-text-primary); margin: 0 0 0.4rem;">2. Use of Service</p>
    <p style="font-size: 13px; color: var(--color-text-secondary); line-height: 1.6; margin: 0 0 1rem;">You agree to use the service only for lawful purposes. You must not use the service in any way that causes, or may cause, damage to the service or impairment of its availability. Any unauthorized use of the service will result in immediate termination of your account.</p>

    <p style="font-size: 14px; font-weight: 500; color: var(--color-text-primary); margin: 0 0 0.4rem;">3. Privacy Policy</p>
    <p style="font-size: 13px; color: var(--color-text-secondary); line-height: 1.6; margin: 0 0 1rem;">We collect and process personal data in accordance with our Privacy Policy. By using our services, you consent to the collection and use of your information as described. We do not sell or share your personal data with third parties without your consent, except as required by law.</p>

    <p style="font-size: 14px; font-weight: 500; color: var(--color-text-primary); margin: 0 0 0.4rem;">4. Intellectual Property</p>
    <p style="font-size: 13px; color: var(--color-text-secondary); line-height: 1.6; margin: 0 0 1rem;">All content, trademarks, logos, and intellectual property on the platform are owned by or licensed to us. You may not copy, reproduce, or distribute any content without our prior written consent.</p>

    <p style="font-size: 14px; font-weight: 500; color: var(--color-text-primary); margin: 0 0 0.4rem;">5. Limitation of Liability</p>
    <p style="font-size: 13px; color: var(--color-text-secondary); line-height: 1.6; margin: 0 0 1rem;">To the maximum extent permitted by law, we shall not be liable for any indirect, incidental, special, or consequential damages arising from your use or inability to use the service, even if we have been advised of the possibility of such damages.</p>

    <p style="font-size: 14px; font-weight: 500; color: var(--color-text-primary); margin: 0 0 0.4rem;">6. Account Responsibilities</p>
    <p style="font-size: 13px; color: var(--color-text-secondary); line-height: 1.6; margin: 0 0 1rem;">You are responsible for maintaining the confidentiality of your account credentials. You agree to notify us immediately of any unauthorized access or breach of security. We will not be liable for any loss arising from unauthorized use of your account.</p>

    <p style="font-size: 14px; font-weight: 500; color: var(--color-text-primary); margin: 0 0 0.4rem;">7. Changes to Terms</p>
    <p style="font-size: 13px; color: var(--color-text-secondary); line-height: 1.6; margin: 0 0 0;">We reserve the right to update these Terms at any time. Continued use of the service after any changes constitutes your acceptance of the new Terms. It is your responsibility to review these Terms periodically.</p>
  </div>
</div>

<script>
const policyLink = document.getElementById('showpolicy');
policyLink.addEventListener('click', function(event) {
  event.preventDefault();
  const policy = document.getElementById('policy');
  policy.style.display = policy.style.display === 'block' ? 'none' : 'block';
});

const checkbox = document.getElementById('policy');
const submitBtn = document.getElementById('submitBtn');
const errorMsg = document.getElementById('errorMsg');

checkbox.addEventListener('change', function() {
  submitBtn.style.opacity = this.checked ? '1' : '0.45';
  if (this.checked) errorMsg.style.display = 'none';
});

submitBtn.addEventListener('mouseover', function() {
  if (checkbox.checked) this.style.background = 'var(--color-background-secondary)';
});
submitBtn.addEventListener('mouseout', function() {
  this.style.background = 'var(--color-background-primary)';
});

function handleSubmit() {
  if (!checkbox.checked) {
    errorMsg.style.display = 'block';
    return;
  }
  errorMsg.style.display = 'none';
  submitBtn.textContent = 'Submitted!';
  submitBtn.style.borderColor = 'var(--color-border-success)';
  submitBtn.style.color = 'var(--color-text-success)';
}
</script>
