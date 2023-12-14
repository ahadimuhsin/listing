import { computed, isRef, unref } from "vue";

export const useMonthlyPayment = (total, interestRate, duration) => {
    const monthlyPayment = computed(() => {
        //isRef untuk mengecek apakah value itu reactive atau tidak
        const principle = isRef(total) ? total.value : total;
        const monthlyInterest = (isRef(interestRate) ?  interestRate.value : interestRate) / 100 / 12;
        const numberOfPaymentMonths = (isRef(duration) ? duration.value : duration) * 12;

        return (
            (principle *
                monthlyInterest *
                Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) /
            (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
        );
    });

    const totalPaid = computed (() => {
        //unref : shortcut untuk isRef(x) ? x.value : x
        return unref(duration) * 12 * monthlyPayment.value
    });

    const totalInterest = computed(() => {
        return totalPaid.value - unref(total)
    })

    return {monthlyPayment, totalPaid, totalInterest}
};
