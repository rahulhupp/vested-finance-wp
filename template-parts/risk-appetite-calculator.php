<style>
  .calculator_box h2 {
    color: #002852;
    font-weight: 600;
    font-size: 24px;
    line-height: 32px;
    margin-bottom: 24px;
  }

  .calculator_progressbar_container {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 24px;
  }

  .portfolio_breakdown {
    width: calc(100% - 222px);
    padding-left: 57px;
  }

  .portfolio_breakdown p {
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .portfolio_breakdown p + p {
    border-top: 1px dashed rgb(6 52 98 / 30%);
    margin-top: 18px;
    padding-top: 18px;
  }

  .portfolio_breakdown p strong {
    position: relative;
    color: #002852;
    font-weight: 400;
    font-size: 16px;
    line-height: 1.1;
    padding-left: 24px;
  }

  .portfolio_breakdown p strong:before {
    content: "";
    width: 16px;
    height: 16px;
    background-color: #002852;
    position: absolute;
    left: 0;
    top: 1px;
    border-radius: 100%;
  }

  .portfolio_breakdown p + p strong:before {
    background-color: #B3D2F1;
  }

  .portfolio_breakdown p span {
    color: #002852;
    font-weight: 500;
    font-size: 22px;
    line-height: 1.1;
  }

  .description_box {
    background-color: #002852;
    border-radius: 6px;
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 24px;
    margin-bottom: 8px;
  }

  .description_content h3 {
    color: #FFFFFF;
    font-weight: 600;
    font-size: 20px;
    line-height: 147%;
  }

  .description_content p {
    color: #FFFFFF;
    font-weight: 400;
    font-size: 16px;
    line-height: 147%;
    margin: 0;
  }

  .description_box a {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #E5E9EE;
    width: 179px;
    height: 48px;
    border-radius: 6px;
  }

  .description_box a span {
    color: #FFFFFF;
    font-weight: 600;
    font-size: 16px;
    line-height: 1;
    padding-bottom: 2px;
    padding-right: 9px;
  }

  .description_content {
    max-width: 348px;
  }

  .calculator_disclosure {
    color: #505A64;
    font-weight: 400;
    font-size: 12px;
    line-height: 16px;
  }

  .range_labels {
    display: flex;
    justify-content: space-between;
    color: #5F7A96;
    font-weight: 400;
    font-size: 18px;
    line-height: 1.1;
  }

  .custom-range-container {
    position: relative;
    width: 100%;
    padding: 7px 0;
    margin-bottom: 13px;
  }

  .custom-track {
    height: 15px;
    background: #D9E4EE;
    border-radius: 20px;
    position: relative;
  }

  .custom-fill {
    height: 15px;
    background: #0CC786;
    border-radius: 20px;
    position: absolute;
    left: 0;
    top: 0;
    width: 50%;
  }

  .custom-thumb {
    width: 17.4px;
    height: 17.4px;
    background: #0CC786;
    border-radius: 50%;
    position: absolute;
    top: -2px;
    left: 50%;
    transform: translateX(-50%);
    cursor: pointer;
    transition: left 0.2s ease;
  }

    .custom-thumb:before {
        content: "";
        width: 29px;
        height: 29px;
        background-color: #0CC786;
        border-radius: 100%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateY(-50%) translateX(-50%);
        opacity: 0.3;
    }

    .custom-thumb:after {
        content: "";
        width: 11.6px;
        height: 11.6px;
        background-color: #FFFFFF;
        border-radius: 100%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateY(-50%) translateX(-50%);
    }

  .progressbar_container {
    position: relative;
    width: 222px;
    height: 222px;
    overflow: hidden;
  }

  .progressbar {
    position: absolute;
    width: 222px;
    height: 222px;
    transform: rotate(-90deg);
  }

  .progressbar__svg {
    position: relative;
    width: 100%;
    height: 100%;
  }

  .progressbar__svg-circle {
    fill: none;
    stroke-dasharray: 440;
    stroke-dashoffset: 440;
    transition: all 0.5s ease;
  }

  #investedCircle {
    stroke: #B3D2F1;
    stroke-width: 8px;
    transform: translate(8px, 8px) scale(1.28);
  }

  #estimatedCircle {
    stroke: #002852;
    stroke-width: 16px;
    transform: translate(3px, 219px) rotateX(180deg) scale(1.35);
  }

  .progressbar_total {
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%);
  }

  .progressbar_total span {
    display: block;
    font-size: 14px;
    font-weight: 400;
    color: #002852;
  }

  .progressbar_total strong {
    display: block;
    font-size: 18px;
    font-weight: 600;
    color: #002852;
  }

  .calculator_slider_container {
    margin-bottom: 28px;
  }

  @media (max-width: 767px) {

    .calculator_box h2 {
        font-size: 24px !important;
        line-height: 32px;
    }

    .range_labels {
        font-size: 16px;
    }

    .portfolio_breakdown {
        width: 100%;
        padding: 57px 0 0;
    }

    .calculator_progressbar {
        width: 100%;
    }

    .progressbar_container {
        margin: auto;
    }

    .description_box a {
        width: 100%;
        justify-content: space-between;
        padding: 0 16px;
    }
  }

</style>

<h2>How can I balance my Global portfolio based on risk appetite?</h2>

<div class="calculator_slider_container">
  <div class="custom-range-container" id="customSliderContainer">
    <div class="custom-track">
      <div class="custom-fill" id="customFillBar"></div>
      <div class="custom-thumb" id="customThumb"></div>
    </div>
  </div>
  <input type="range" id="riskSlider" min="0" max="4" value="2" step="1" hidden>
  <div class="range_labels">
    <span>More Conservative</span>
    <span>More Aggressive</span>
  </div>
</div>

<div class="calculator_progressbar_container">
  <div class="calculator_progressbar">
    <div class="progressbar_container">
      <div class="progressbar">
        <svg class="progressbar__svg">
          <circle cx="80" cy="80" r="70" class="progressbar__svg-circle" id="investedCircle"></circle>
        </svg>
      </div>
      <div class="progressbar">
        <svg class="progressbar__svg">
          <circle cx="80" cy="80" r="70" class="progressbar__svg-circle" id="estimatedCircle"></circle>
        </svg>
      </div>
      <div class="progressbar_total">
        <span>Total Value</span>
        <strong id="totalValue">$5,000</strong>
      </div>
    </div>
  </div>

  <div class="portfolio_breakdown" id="portfolioText">
    <p><strong>Core Portfolio: Moderate</strong> <span>80%</span></p>
    <p><strong>Thematic Portfolios</strong> <span>20%</span></p>
  </div>
</div>

<div class="description_box" id="descriptionBox">
  <div class="description_content">
    <h3>The Wealth Protector:</h3>
    <p>You balance risk and return with a mix of assets</p>
  </div>
  <a href="#">
    <span>Start Investing</span>
    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M1 12.999L7 6.99902L0.999999 0.999023" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </a>
</div>

<div class="calculator_disclosure">
  For illustrative purposes only. This does not constitute a recommendation to purchase any security or investment advice.
</div>
<script>
  const riskSlider = document.getElementById("riskSlider");
  const investedCircle = document.getElementById("investedCircle");
  const estimatedCircle = document.getElementById("estimatedCircle");
  const portfolioText = document.getElementById("portfolioText");
  const descriptionBox = document.getElementById("descriptionBox");
  const fillBar = document.getElementById("customFillBar");
  const thumb = document.getElementById("customThumb");
  const customSlider = document.getElementById("customSliderContainer");

  const totalStroke = 440;

  const options = [
    { label: "The Wealth Protector", description: "You prioritize safety and stable returns, avoiding risk.", coreLabel: "Core Portfolio: Conservative", core: 100, thematic: 0 },
    { label: "", description: "You seek slow, steady growth with limited risk exposure", coreLabel: "Core Portfolio: Conservative", core: 90, thematic: 10 },
    { label: "The Wealth Protector", description: "You balance risk and return with a mix of assets", coreLabel: "Core Portfolio: Moderate", core: 80, thematic: 20 },
    { label: "", description: "You are willing to take risks for higher long-term gains", coreLabel: "Core Portfolio: Aggressive", core: 80, thematic: 20 },
    { label: "", description: "You pursue maximum returns with high-risk investments", coreLabel: "Core Portfolio: Aggressive", core: 70, thematic: 30 },
  ];

  function updateUI(value) {
    const opt = options[value];
    const investedOffset = totalStroke - (totalStroke * opt.thematic) / 100;
    const estimatedOffset = totalStroke - (totalStroke * opt.core) / 100;

    investedCircle.style.strokeDashoffset = investedOffset;
    estimatedCircle.style.strokeDashoffset = estimatedOffset;

    portfolioText.innerHTML = `
      <p><strong>${opt.coreLabel}</strong> <span>${opt.core}%</span></p>
      <p><strong>Thematic Portfolios</strong> <span>${opt.thematic}%</span></p>
    `;

    descriptionBox.innerHTML = `
      <div class="description_content">
          <h3>${opt.label || opt.coreLabel}</h3>
          <p>${opt.description}</p>
      </div>
      <a href="#">
          <span>Start Investing</span>
          <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1 12.999L7 6.99902L0.999999 0.999023" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
      </a>
    `;
  }

  function updateSliderVisual(val) {
    const max = parseInt(riskSlider.max);
    const percent = (val / max) * 100;
    fillBar.style.width = percent + "%";
    thumb.style.left = percent + "%";
  }

  function setSliderValueFromEvent(e) {
    const bounds = customSlider.getBoundingClientRect();
    const x = Math.min(Math.max(e.clientX - bounds.left, 0), bounds.width);
    const percent = x / bounds.width;
    const value = Math.round(percent * parseInt(riskSlider.max));
    riskSlider.value = value;
    updateUI(value);
    updateSliderVisual(value);
  }

  // Enable click and drag
  let isDragging = false;

  customSlider.addEventListener("mousedown", (e) => {
    isDragging = true;
    setSliderValueFromEvent(e);
  });

  document.addEventListener("mousemove", (e) => {
    if (isDragging) {
      setSliderValueFromEvent(e);
    }
  });

  document.addEventListener("mouseup", () => {
    if (isDragging) {
      isDragging = false;
    }
  });

  // Initial render
  const initialValue = parseInt(riskSlider.value);
  updateUI(initialValue);
  updateSliderVisual(initialValue);
</script>
