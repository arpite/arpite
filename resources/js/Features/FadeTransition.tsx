import { Transition } from "@headlessui/react";
import React, { ReactElement, useEffect, useState } from "react";

interface FadeTransitionInterface {
	child: ReactElement | null;
	as?: React.FC | string;
	className?: string;
}

/**
 * This component makes it easy to add fadeIn and
 * fadeOut transitions for adding and removing nodes.
 */
export const FadeTransition: React.FC<FadeTransitionInterface> = ({
	child: givenChild,
	as,
	className,
}) => {
	const [activeChild, setActiveChild] = useState(givenChild);

	useEffect(() => {
		if (givenChild !== null) {
			setActiveChild(givenChild);
		}
	}, [givenChild]);

	if (activeChild === null) {
		return <></>;
	}

	return (
		<Transition
			show={givenChild !== null}
			// eslint-disable-next-line
			as={as as any}
			appear={true}
			enter="transition-opacity duration-200"
			enterFrom="opacity-0"
			enterTo="opacity-100"
			leave="transition-opacity duration-200"
			leaveFrom="opacity-100"
			leaveTo="opacity-0"
			afterLeave={() => setActiveChild(null)}
			className={className}
		>
			{activeChild}
		</Transition>
	);
};
