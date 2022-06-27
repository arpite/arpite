import React from "react";
import { Button } from "./Nodes/Button";
import { Form } from "./Nodes/Form/Form";
import { Grid } from "./Nodes/Grid";
import { PaginatedTable } from "./Nodes/PaginatedTable";
import { Panel } from "./Nodes/Panel";
import { SelectField } from "./Nodes/Form/Fields/SelectField";
import { TableCell } from "./Nodes/Table/Cells/TableCell";
import { Link } from "./Nodes/Link/Link";
import { Table } from "./Nodes/Table/Table";
import { Tabs } from "./Nodes/Tabs/Tabs";
import { TextField } from "./Nodes/Form/Fields/TextField";
import { NodeType } from "./NodeType";
import { Modal } from "./Nodes/Modal/Modal";
import { TableLinks } from "./Nodes/Table/Cells/TableLinks";
import { EmptyState } from "./Nodes/EmptyState";
import { Text } from "./Nodes/Text";
import { Row } from "./Nodes/Row";
import { Image } from "./Nodes/Image";
import { Tooltip } from "./Nodes/Tooltip";
import { NumberField } from "./Nodes/Form/Fields/NumberField";
import { HasManyField } from "./Nodes/Form/Fields/HasManyField";
import { Timeline } from "./Nodes/Timeline/Timeline";
import { TimelineItem } from "./Nodes/Timeline/TimelineItem";
import { WizardContent } from "./Nodes/Wizard/WizardContent";
import { Alert } from "./Nodes/Alert/Alert";
import { FilesDisplay } from "./Nodes/FilesDisplay/FilesDisplay";
import { FileItem } from "./Nodes/FilesDisplay/FileItem";
import { AddressDisplay } from "./Nodes/AddressDisplay";
import { RadiosField } from "./Nodes/Form/Fields/RadiosField";
import { ToggleField } from "./Nodes/Form/Fields/ToggleField";
import { FormButton } from "./Nodes/Form/FormButton";
import { WizardHeader } from "./Nodes/Wizard/WizardHeader";
import { Card } from "./Nodes/Card/Card";
import { PricingPlans } from "./Nodes/PricingPlans/PricingPlans";
import { PricingPlan } from "./Nodes/PricingPlans/PricingPlan";
import { CurrentPricingPlan } from "./Nodes/PricingPlans/CurrentPricingPlan";
import { CurrentPricingPlans } from "./Nodes/PricingPlans/CurrentPricingPlans";
import { FileField } from "./Nodes/Form/Fields/FileField";
import { Splitter } from "./Nodes/Splitter";
import { CheckboxField } from "./Nodes/Form/Fields/CheckboxField";
import { Flex } from "./Nodes/Flex";
import { BalanceInformation } from "./Nodes/BalanceInformation";
import { Chart } from "./Nodes/Chart/Chart";
import { ShopConnectionPanel } from "../ShopConnectionPanel";
import { AlertBanner } from "./Nodes/AlertBanner";
import { TextareaField } from "./Nodes/Form/Fields/TextareaField";
import { Metric } from "./Nodes/Metric/Metric";
import { Cygnus } from "../../Cygnus";

export const RenderNode: React.FC<NodeType> = ({ nodeType, ...props }) => {
	// eslint-disable-next-line
	const Component: React.FC<any> = {
		Grid,
		Flex,
		Row,
		Panel,
		Button,
		Form,
		FormButton,
		PricingPlans,
		PricingPlan,
		CurrentPricingPlan,
		CurrentPricingPlans,
		Tabs,
		Table,
		Link,
		Text,
		Image,
		Timeline,
		TimelineItem,
		TableCell,
		TableLinks,
		Tooltip,
		Card,
		WizardHeader,
		WizardContent,
		EmptyState,
		PaginatedTable,
		Modal,
		Alert,
		TextField,
		TextareaField,
		NumberField,
		SelectField,
		HasManyField,
		RadiosField,
		CheckboxField,
		ToggleField,
		FileField,
		AddressDisplay,
		FileItem,
		FilesDisplay,
		Splitter,
		BalanceInformation,
		Chart,
		Metric,
		ShopConnectionPanel,
		AlertBanner,
		...Cygnus.getCustomNodes(),
	}[nodeType];

	if (Component) {
		/**
		 * We use stringified props as key so we could be sure
		 * that frontend is fully and properly updated by the new
		 * json.
		 */
		return <Component key={JSON.stringify(props)} {...props} />;
	}

	console.warn(`Component "${nodeType}" was not found!`);
	return null;
};
