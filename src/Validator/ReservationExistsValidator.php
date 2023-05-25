<?php

namespace App\Validator;

use App\Entity\Calendar;
use App\Repository\CalendarRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ReservationExistsValidator extends ConstraintValidator
{
    private $calendarRepository;

    public function __construct(CalendarRepository $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ReservationExists) {
            throw new UnexpectedTypeException($constraint, ReservationExists::class);
        }

        if (!$value instanceof \DateTimeInterface) {
            return;
        }

        $existingReservation = $this->calendarRepository->findReservationByDate($value);

        if ($existingReservation != 0) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
