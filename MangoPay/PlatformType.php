<?php
namespace MangoPay;

/**
 * Platform types
 */
class PlatformType
{
    const Marketplace = 'MARKETPLACE';
    const P2pPayment = 'P2P_PAYMENT';
    const CrowdfundingDonation = 'CROWDFUNDING_DONATION';
    const CrowdfundingReward = 'CROWDFUNDING_REWARD';
    const CrowdfundingEquity = 'CROWDFUNDING_EQUITY';
    const CrowdfundingLoan = 'CROWDFUNDING_LOAN';
    const Other = 'OTHER';
}