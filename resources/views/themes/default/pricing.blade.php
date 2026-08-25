@php
  $free_requests = config("config.free_api_requests_per_key");
  $plans = get_plans();
  $comparison_rows = get_comparison_rows();
  $faqs = get_faqs();
@endphp

<div class="container mb-5">
  <div class="pricing-table">

      {{-- Top banners --}}
      <div class="pricing-table-banners">
          @if($free_requests > 0)
              <div class="pricing-banner pricing-banner-free">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M20 12v9H4v-9M2 7h20v5H2V7zm10 0v14M12 7c-1-3-4-4-5-2s1 2 5 2zm0 0c1-3 4-4 5-2s-1 2-5 2z"
                            stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span>Your first API key comes with <strong>{{ format_number($free_requests) }} free requests</strong> — no card required.</span>
              </div>
          @endif
          <div class="pricing-banner pricing-banner-neutral">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M18.178 8c-2.87 0-4.5 2.5-6.178 4-1.678 1.5-3.308 4-6.178 4A4 4 0 1 1 5.822 8c2.87 0 4.5 2.5 6.178 4 1.678 1.5 3.308 4 6.178 4a4 4 0 1 0 0-8z"
                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span>Pay once, use anytime — credits never expire and there's no monthly fee.</span>
          </div>
      </div>

      {{-- Plan cards --}}
      <div class="row g-4 justify-content-center">
          @foreach($plans as $plan)
              @php
                $per_request = price_per_request($plan);
              @endphp

              <div class="col-12 col-sm-6 col-lg-3">
                  <div class="plan-card
                      {{ !empty($plan['popular']) ? 'plan-card-popular' : '' }}
                      {{ !empty($plan['is_custom']) ? 'plan-card-custom' : '' }}">

                      @if(!empty($plan['popular']))
                          <div class="plan-card-ribbon">Most popular</div>
                      @endif

                      <div class="plan-card-header">
                          <h3 class="plan-card-name">{{ $plan['name'] }}</h3>
                          @if(!empty($plan['description']))
                              <p class="plan-card-description">{{ $plan['description'] }}</p>
                          @endif
                      </div>

                      <div class="plan-card-price">
                          <span class="plan-card-amount">
                              {{ !empty($plan['is_custom']) ? 'Custom' : format_currency($plan['price'] ?? null) }}
                          </span>
                          @if(empty($plan['is_custom']))
                              <span class="plan-card-period">one-time</span>
                          @endif
                      </div>

                      <div class="plan-card-equivalent">{{ $per_request }} / request</div>

                      <ul class="plan-card-stats">
                          <li>
                              <span class="plan-card-stats-label">API requests</span>
                              <span class="plan-card-stats-value">
                                  {{ !empty($plan['is_custom']) ? 'Flexible' : format_number($plan['requests'] ?? null) }}
                              </span>
                          </li>
                          <li>
                              <span class="plan-card-stats-label">Rate limit</span>
                              <span class="plan-card-stats-value">{{ $plan['rate_limit'] ?? '—' }}</span>
                          </li>
                          <li>
                              <span class="plan-card-stats-label">Support</span>
                              <span class="plan-card-stats-value">{{ $plan['support'] ?? '—' }}</span>
                          </li>
                          <li>
                              <span class="plan-card-stats-label">Uptime SLA</span>
                              <span class="plan-card-stats-value">{{ $plan['uptime_sla'] ?? '—' }}</span>
                          </li>
                      </ul>

                      @if(!empty($plan['features']))
                          <ul class="plan-card-features">
                              @foreach($plan['features'] as $feature)
                                  <li>
                                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                          <path d="M13.5 4.5L6.5 11.5L2.5 7.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                                      </svg>
                                      <span>{{ $feature }}</span>
                                  </li>
                              @endforeach
                          </ul>
                      @endif

                      @if ($plan["id"] !== "trial")
                        <div class="plan-card-cta mt-3">
                            <button type="button"
                              onclick="onclick_cta('{{ json_encode($plan) }}');"
                              class="btn w-100 {{ !empty($plan['popular']) ? 'btn-primary' : 'btn-outline-primary' }}">
                                {{ $plan['cta_label'] ?? (!empty($plan['is_custom']) ? 'Contact sales' : 'Buy credits') }}
                            </button>
                        </div>
                      @endif
                  </div>
              </div>
          @endforeach
      </div>

      {{-- Feature comparison table --}}
      <div class="pricing-comparison table-responsive">
          <table class="table align-middle pricing-comparison-table">
              <thead>
                  <tr>
                      <th scope="col" class="pricing-comparison-row-label">Plan</th>
                      @foreach($plans as $plan)
                          <th scope="col" class="{{ !empty($plan['popular']) ? 'pricing-comparison-highlight' : '' }}">
                              {{ $plan['name'] }}
                              @if(!empty($plan['popular']))
                                  <span class="badge text-bg-primary ms-2">Popular</span>
                              @endif
                          </th>
                      @endforeach
                  </tr>
              </thead>
              <tbody>
                  @foreach($comparison_rows as $row)
                      <tr>
                          <th scope="row" class="pricing-comparison-row-label">{{ $row['label'] }}</th>
                          @foreach($plans as $plan)
                              <td class="{{ !empty($plan['popular']) ? 'pricing-comparison-highlight' : '' }}">
                                  {{ $row['value']($plan) }}
                              </td>
                          @endforeach
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>

      {{-- FAQ accordion --}}
      <div class="pricing-faq mt-5">
          <h4 class="mb-3">Frequently asked questions</h4>
          <div class="accordion" id="pricingFaq">
              @foreach($faqs as $index => $faq)
                  @php
                      $headingId = 'pricingFaqHeading' . $index;
                      $collapseId = 'pricingFaqCollapse' . $index;
                  @endphp
                  <div class="accordion-item">
                      <h2 class="accordion-header" id="{{ $headingId }}">
                          <button class="accordion-button collapsed" type="button"
                                  data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                  aria-expanded="false" aria-controls="{{ $collapseId }}">
                              {{ $faq['question'] }}
                          </button>
                      </h2>
                      <div id="{{ $collapseId }}" class="accordion-collapse collapse"
                           aria-labelledby="{{ $headingId }}" data-bs-parent="#pricingFaq">
                          <div class="accordion-body text-muted">{{ $faq['answer'] }}</div>
                      </div>
                  </div>
              @endforeach
          </div>
      </div>

  </div>
</div>

<script>
  function onclick_cta(plan) {
    plan = JSON.parse(plan);

    tidioChatApi.open();

    const message = `Hi! I'm interested in purchasing the "${plan.name}" plan ($${plan.price}) with ${plan.requests.toLocaleString()} requests. Please help me complete the purchase.`;

    tidioChatApi.messageFromVisitor(message);
  }
</script>

<style>
    /* public/css/pricing.css
       Companion styles for pricing.blade.php. Load Bootstrap 5 separately —
       this only adds what Bootstrap doesn't provide. */

    .pricing-table {
      --plan-border: #e5e7eb;
      --plan-accent: #0d6efd;
      --plan-accent-soft: #eef4ff;
      --plan-text-muted: #6b7280;
    }

    /* ---------------------------------------------------------------- */
    /* Top banners                                                       */
    /* ---------------------------------------------------------------- */
    .pricing-table-banners {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 2rem;
    }

    .pricing-banner {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.875rem;
      padding: 0.5rem 1rem;
      border-radius: 999px;
      text-align: center;
    }

    .pricing-banner-free {
      background: #fff7ed;
      color: #9a3412;
      border: 1px solid #fed7aa;
    }

    .pricing-banner-neutral {
      background: #f3f4f6;
      color: #374151;
    }

    .pricing-banner svg {
      flex: 0 0 auto;
    }

    /* ---------------------------------------------------------------- */
    /* Plan card                                                         */
    /* ---------------------------------------------------------------- */
    .plan-card {
      position: relative;
      display: flex;
      flex-direction: column;
      height: 100%;
      background: #fff;
      border: 1px solid var(--plan-border);
      border-radius: 0.75rem;
      padding: 1.75rem 1.5rem;
      transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .plan-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 0.5rem 1.5rem rgba(17, 24, 39, 0.06);
    }

    .plan-card-popular {
      border-color: var(--plan-accent);
      box-shadow: 0 0.5rem 1.5rem rgba(13, 110, 253, 0.12);
    }

    .plan-card-custom {
      background: #fafafa;
      border-style: dashed;
    }

    .plan-card-ribbon {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translate(-50%, -50%);
      background: var(--plan-accent);
      color: #fff;
      font-size: 0.6875rem;
      font-weight: 700;
      letter-spacing: 0.02em;
      text-transform: uppercase;
      padding: 0.3rem 0.9rem;
      border-radius: 999px;
      white-space: nowrap;
    }

    .plan-card-header {
      margin-bottom: 1rem;
    }

    .plan-card-name {
      font-size: 1.125rem;
      font-weight: 700;
      margin: 0 0 0.25rem;
      color: #111827;
    }

    .plan-card-description {
      font-size: 0.8125rem;
      color: var(--plan-text-muted);
      margin: 0;
      min-height: 2.2em;
    }

    .plan-card-price {
      display: flex;
      align-items: baseline;
      gap: 0.4rem;
      margin-bottom: 0.15rem;
    }

    .plan-card-amount {
      font-size: 2.25rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: #111827;
      font-variant-numeric: tabular-nums;
    }

    .plan-card-period {
      font-size: 0.8125rem;
      color: var(--plan-text-muted);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.02em;
    }

    .plan-card-equivalent {
      font-size: 0.75rem;
      color: var(--plan-text-muted);
      margin-bottom: 0.75rem;
    }

    .plan-card-stats {
      list-style: none;
      margin: 0.75rem 0 0;
      padding: 0.15rem 0;
      background: var(--plan-accent-soft);
      border-radius: 0.5rem;
    }

    .plan-card-stats li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.45rem 0.75rem;
      font-size: 0.8125rem;
    }

    .plan-card-stats li + li {
      border-top: 1px solid rgba(13, 110, 253, 0.08);
    }

    .plan-card-stats-label {
      color: #4b5563;
    }

    .plan-card-stats-value {
      font-weight: 600;
      color: #111827;
      font-variant-numeric: tabular-nums;
      text-align: right;
    }

    .plan-card-features {
      list-style: none;
      margin: 1rem 0 1.5rem;
      padding: 0;
      flex: 1 1 auto;
    }

    .plan-card-features li {
      display: flex;
      align-items: flex-start;
      gap: 0.5rem;
      font-size: 0.8125rem;
      color: #374151;
      padding: 0.3rem 0;
    }

    .plan-card-features li svg {
      flex: 0 0 auto;
      margin-top: 0.15rem;
      color: var(--plan-accent);
    }

    .plan-card-cta {
      margin-top: auto;
    }

    /* ---------------------------------------------------------------- */
    /* Feature comparison table                                          */
    /* ---------------------------------------------------------------- */
    .pricing-comparison {
      margin-top: 3rem;
    }

    .pricing-comparison-table {
      border-collapse: separate;
      border-spacing: 0;
    }

    .pricing-comparison-table thead th {
      text-align: center;
      font-size: 0.9375rem;
      font-weight: 700;
      color: #111827;
      border-bottom: 2px solid #e5e7eb;
      padding: 0.85rem 1rem;
      white-space: nowrap;
    }

    .pricing-comparison-table tbody th {
      font-size: 0.8125rem;
      font-weight: 600;
      color: #4b5563;
      white-space: nowrap;
      padding: 0.75rem 1rem;
    }

    .pricing-comparison-table tbody td {
      font-size: 0.8125rem;
      color: #111827;
      text-align: center;
      padding: 0.75rem 1rem;
      font-variant-numeric: tabular-nums;
    }

    .pricing-comparison-table tbody tr:nth-child(odd) {
      background: #fafafa;
    }

    .pricing-comparison-row-label {
      text-align: left !important;
      background: #fff;
    }

    .pricing-comparison-highlight {
      background: #eef4ff !important;
    }

    /* ---------------------------------------------------------------- */
    /* FAQ accordion                                                     */
    /* ---------------------------------------------------------------- */
    .pricing-faq .accordion-button:not(.collapsed) {
      color: #0d6efd;
      background-color: var(--plan-accent-soft, #eef4ff);
      box-shadow: none;
    }

    .pricing-faq .accordion-button:focus {
      box-shadow: none;
      border-color: var(--plan-border);
    }
</style>